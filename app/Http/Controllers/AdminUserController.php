<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AuditLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminUserController extends Controller
{
    /**
     * Display a listing of all users for the administration team.
     */
    public function index(Request $request)
    {
        // Enforce admin authorization
        if (!Auth::user()->isAdmin()) {
            return redirect('/')->with('error', 'Unauthorized access.');
        }

        $query = User::query();

        // 1. Text Search across name, email, phone, city, id number, and business name
        if ($search = trim($request->input('q', $request->input('search', '')))) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('address_city', 'like', "%{$search}%")
                  ->orWhere('id_number', 'like', "%{$search}%")
                  ->orWhere('business_name', 'like', "%{$search}%");
            });
        }

        // 2. Filter by Role
        if ($role = $request->input('role')) {
            if (in_array($role, ['buyer', 'seller', 'admin'])) {
                $query->where('role', $role);
            }
        }

        // 3. Filter by Verification Status
        if ($verification = $request->input('verification')) {
            if ($verification === 'verified') {
                $query->where('is_verified', true);
            } elseif ($verification === 'pending') {
                $query->where(function ($q) {
                    $q->where('id_verification_status', 'pending')
                      ->orWhere(function ($sub) {
                          $sub->where('role', 'buyer')->where('is_verified', false);
                      });
                });
            } elseif ($verification === 'unverified') {
                $query->where('is_verified', false);
            }
        }

        // 4. Filter by Account Standing / Status
        if ($status = $request->input('status')) {
            if ($status === 'banned') {
                $query->where('is_banned', true);
            } elseif ($status === 'suspended') {
                $query->where('is_suspended', true);
            } elseif ($status === 'active') {
                $query->where('is_banned', false)->where('is_suspended', false);
            }
        }

        // 5. Sorting
        $sort = $request->input('sort', 'latest');
        switch ($sort) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'impact':
                $query->orderBy('total_impact_score', 'desc');
                break;
            case 'weight':
                $query->orderBy('total_weight_diverted', 'desc');
                break;
            case 'latest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        // Aggregate statistics for overview metric tiles
        $stats = [
            'total' => User::count(),
            'buyers' => User::where('role', 'buyer')->count(),
            'sellers' => User::where('role', 'seller')->count(),
            'admins' => User::where('role', 'admin')->count(),
            'verified' => User::where('is_verified', true)->count(),
            'pending' => User::where(function ($q) {
                $q->where('id_verification_status', 'pending')
                  ->orWhere(function ($sub) {
                      $sub->where('role', 'buyer')->where('is_verified', false);
                  });
            })->count(),
            'restricted' => User::where('is_banned', true)->orWhere('is_suspended', true)->count(),
        ];

        $users = $query->paginate(15)->withQueryString();

        return view('admin.users.index', compact('users', 'stats', 'search', 'role', 'verification', 'status', 'sort'));
    }

    /**
     * Show single user profile details modal or JSON payload.
     */
    public function show(User $user)
    {
        if (!Auth::user()->isAdmin()) {
            return redirect('/')->with('error', 'Unauthorized access.');
        }

        $user->loadCount(['listings', 'offers']);
        
        if (request()->wantsJson()) {
            return response()->json($user);
        }

        return redirect()->route('users.show', $user);
    }

    /**
     * Toggle ban or suspension on a user.
     */
    public function toggleStatus(Request $request, User $user)
    {
        if (!Auth::user()->isAdmin()) {
            return redirect('/')->with('error', 'Unauthorized access.');
        }

        // Prevent self-restriction
        if ($user->id === Auth::id()) {
            return back()->with('error', 'You cannot restrict or ban your own administrative account.');
        }

        $validated = $request->validate([
            'action' => 'required|in:ban,unban,suspend,unsuspend',
            'reason' => 'nullable|string|max:255',
        ]);

        $oldValues = [
            'is_banned' => $user->is_banned,
            'is_suspended' => $user->is_suspended,
            'suspended_until' => $user->suspended_until,
        ];

        switch ($validated['action']) {
            case 'ban':
                $user->update([
                    'is_banned' => true,
                    'is_suspended' => false,
                    'suspended_until' => null,
                ]);
                $message = "User {$user->name} has been permanently banned.";
                break;

            case 'unban':
                $user->update(['is_banned' => false]);
                $message = "User {$user->name} has been unbanned and restored to active standing.";
                break;

            case 'suspend':
                $user->update([
                    'is_suspended' => true,
                    'suspended_until' => now()->addDays(7),
                ]);
                $message = "User {$user->name} has been suspended for 7 days.";
                break;

            case 'unsuspend':
                $user->update([
                    'is_suspended' => false,
                    'suspended_until' => null,
                ]);
                $message = "Suspension lifted for {$user->name}.";
                break;
        }

        AuditLogger::log(
            action: 'update_user_status',
            description: "Admin {$validated['action']} user: {$user->name} ({$user->email}). " . ($validated['reason'] ?? ''),
            modelType: 'User',
            modelId: $user->id,
            oldValues: $oldValues,
            newValues: $user->only(['is_banned', 'is_suspended', 'suspended_until'])
        );

        return back()->with('success', $message);
    }

    /**
     * Quick toggle verification status.
     */
    public function toggleVerification(Request $request, User $user)
    {
        if (!Auth::user()->isAdmin()) {
            return redirect('/')->with('error', 'Unauthorized access.');
        }

        $newStatus = !$user->is_verified;

        $user->update([
            'is_verified' => $newStatus,
            'id_verification_status' => $newStatus ? 'verified' : 'unsubmitted',
            'email_verified_at' => $newStatus ? ($user->email_verified_at ?? now()) : $user->email_verified_at,
        ]);

        AuditLogger::log(
            action: 'toggle_user_verification',
            description: "Admin changed verification of {$user->name} ({$user->email}) to: " . ($newStatus ? 'Verified' : 'Unverified'),
            modelType: 'User',
            modelId: $user->id,
            newValues: ['is_verified' => $newStatus]
        );

        return back()->with('success', "User {$user->name} is now " . ($newStatus ? 'Verified' : 'Unverified') . ".");
    }

    /**
     * Change user role (e.g. promote buyer to seller or vice versa).
     */
    public function updateRole(Request $request, User $user)
    {
        if (!Auth::user()->isAdmin()) {
            return redirect('/')->with('error', 'Unauthorized access.');
        }

        $validated = $request->validate([
            'role' => 'required|in:buyer,seller,admin',
        ]);

        $oldRole = $user->role;
        $user->update(['role' => $validated['role']]);

        // If promoted to seller and doesn't have business name yet, give default
        if ($validated['role'] === 'seller' && empty($user->business_name)) {
            $user->update([
                'business_name' => $user->name . ' Tech & Scrap Hub',
                'business_description' => 'E-waste trader and circular electronics partner in San Carlos City, Pangasinan.',
            ]);
        }

        AuditLogger::log(
            action: 'update_user_role',
            description: "Admin changed role of {$user->name} from {$oldRole} to {$validated['role']}",
            modelType: 'User',
            modelId: $user->id,
            oldValues: ['role' => $oldRole],
            newValues: ['role' => $validated['role']]
        );

        return back()->with('success', "Updated {$user->name}'s role to " . ucfirst($validated['role']) . ".");
    }

    /**
     * Delete user account.
     */
    public function destroy(User $user)
    {
        if (!Auth::user()->isAdmin()) {
            return redirect('/')->with('error', 'Unauthorized access.');
        }

        if ($user->id === Auth::id()) {
            return back()->with('error', 'You cannot delete your own administrative account.');
        }

        $name = $user->name;
        $email = $user->email;

        AuditLogger::log(
            action: 'delete_user',
            description: "Admin deleted user account: {$name} ({$email})",
            modelType: 'User',
            modelId: $user->id
        );

        $user->delete();

        return back()->with('success', "User account {$name} has been removed successfully.");
    }
}
