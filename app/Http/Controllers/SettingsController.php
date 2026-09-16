<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SettingsController extends Controller
{
    /**
     * Show the settings page with user stats.
     */
    public function index(): View
    {
        $user = Auth::user();
        $stats = [];

        if ($user->isSeller()) {
            $stats = [
                'total_listings' => $user->listings()->count(),
                'active_listings' => $user->listings()->where('status', 'available')->count(),
                'sold_items' => $user->listings()->where('status', 'matched')->orWhere('status', 'processed')->count(),
                'co2_saved' => round($user->total_co2_saved ?? 0, 2),
                'items_processed' => $user->items_processed ?? 0,
            ];
        }

        return view('settings.index', compact('stats'));
    }

    /**
     * Update notification preferences.
     */
    public function updateNotifications(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email_notifications' => ['required', 'boolean'],
            'sms_notifications' => ['required', 'boolean'],
            'marketing_updates' => ['required', 'boolean'],
            'notify_new_offer' => ['required', 'boolean'],
            'notify_transaction_complete' => ['required', 'boolean'],
            'notify_new_message' => ['required', 'boolean'],
            'notify_admin_updates' => ['required', 'boolean'],
        ]);

        $request->user()->update($validated);

        return redirect()->back()->with('success', 'Notification preferences updated successfully.');
    }

    /**
     * Update privacy settings.
     */
    public function updatePrivacy(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'profile_visibility' => ['required', 'in:public,private'],
        ]);

        $request->user()->update($validated);

        return redirect()->back()->with('success', 'Privacy settings updated successfully.');
    }

    /**
     * Update payment preferences.
     */
    public function updatePayments(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'gcash_number' => ['nullable', 'string', 'regex:/^(09|\+639)\d{9}$/'],
            'bank_name' => ['nullable', 'string', 'max:100'],
            'bank_account_number' => ['nullable', 'string', 'max:50'],
        ]);

        $request->user()->update($validated);

        return redirect()->back()->with('success', 'Payment preferences updated successfully.');
    }

    /**
     * Update seller profile settings.
     */
    public function updateSellerProfile(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'business_name' => ['nullable', 'string', 'max:255'],
            'business_description' => ['nullable', 'string', 'max:1000'],
            'preferred_action' => ['nullable', 'in:sell,recycle'],
            'address_city' => ['nullable', 'string', 'max:100'],
            'address_province' => ['nullable', 'string', 'max:100'],
        ]);

        $request->user()->update($validated);

        return redirect()->back()->with('success', 'Seller profile updated successfully.');
    }

    /**
     * Submit government ID and physical location verification documents (Buyer & Seller).
     */
    public function submitIdVerification(Request $request): RedirectResponse
    {
        $user = $request->user();

        $photoRule = $user->id_photo_url ? ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:4096'] : ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:4096'];

        $validated = $request->validate([
            'id_type' => ['required', 'string', 'max:100'],
            'id_number' => ['required', 'string', 'max:100'],
            'id_photo' => $photoRule,
            'id_back_photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:4096'],
            'id_selfie' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:4096'],
            'proof_of_address' => ['nullable', 'file', 'mimes:jpeg,png,jpg,webp,pdf', 'max:4096'],
            'proof_of_address_type' => ['nullable', 'string', 'max:100'],
            // Location fields
            'address_line_1' => ['nullable', 'string', 'max:255'],
            'barangay' => ['nullable', 'string', 'max:100'],
            'address_city' => ['nullable', 'string', 'max:100'],
            'address_province' => ['nullable', 'string', 'max:100'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'location_notes' => ['nullable', 'string', 'max:500'],
        ]);

        $updateData = [
            'id_type' => $validated['id_type'],
            'id_number' => $validated['id_number'],
            'id_verification_status' => 'pending',
            'id_submitted_at' => now(),
            'id_rejection_reason' => null,
        ];

        if ($request->hasFile('id_photo')) {
            $uploaded = \App\Services\CloudflareStorageService::upload($request->file('id_photo'), 'verifications');
            $updateData['id_photo_url'] = \App\Services\CloudflareStorageService::url($uploaded);
        }

        if ($request->hasFile('id_back_photo')) {
            $uploadedBack = \App\Services\CloudflareStorageService::upload($request->file('id_back_photo'), 'verifications');
            $updateData['id_back_photo_url'] = \App\Services\CloudflareStorageService::url($uploadedBack);
        }

        if ($request->hasFile('id_selfie')) {
            $uploadedSelfie = \App\Services\CloudflareStorageService::upload($request->file('id_selfie'), 'verifications');
            $updateData['id_selfie_url'] = \App\Services\CloudflareStorageService::url($uploadedSelfie);
        }

        if ($request->hasFile('proof_of_address')) {
            $uploadedProof = \App\Services\CloudflareStorageService::upload($request->file('proof_of_address'), 'verifications');
            $updateData['proof_of_address_url'] = \App\Services\CloudflareStorageService::url($uploadedProof);
        }

        if ($request->filled('proof_of_address_type')) {
            $updateData['proof_of_address_type'] = $request->input('proof_of_address_type');
        }

        if ($request->filled('address_line_1')) {
            $updateData['address_line_1'] = $request->input('address_line_1');
        }
        if ($request->filled('barangay')) {
            $updateData['barangay'] = $request->input('barangay');
        }
        if ($request->filled('address_city')) {
            $updateData['address_city'] = $request->input('address_city');
        }
        if ($request->filled('address_province')) {
            $updateData['address_province'] = $request->input('address_province');
        }
        if ($request->filled('postal_code')) {
            $updateData['postal_code'] = $request->input('postal_code');
        }
        if ($request->filled('location_notes')) {
            $updateData['location_notes'] = $request->input('location_notes');
        }

        $user->update($updateData);

        // Sync or create primary pickup address entry
        if ($request->filled('address_line_1') || $request->filled('address_city')) {
            $primaryAddress = $user->addresses()->where('is_primary', true)->first()
                ?: $user->addresses()->first();

            $addressPayload = [
                'label' => $user->isSeller() ? 'Seller Pickup Location' : 'Primary Address',
                'address_line_1' => $request->input('address_line_1') ?? ($user->address_line_1 ?? 'Registered Address'),
                'address_line_2' => $request->input('barangay') ? 'Brgy. ' . $request->input('barangay') : null,
                'city' => $request->input('address_city') ?? ($user->address_city ?? 'Metro Manila'),
                'state' => $request->input('address_province') ?? ($user->address_province ?? 'NCR'),
                'postal_code' => $request->input('postal_code') ?? ($user->postal_code ?? '1000'),
                'country' => 'Philippines',
                'special_instructions' => $request->input('location_notes'),
                'type' => 'pickup',
                'is_primary' => true,
            ];

            if ($primaryAddress) {
                $primaryAddress->update($addressPayload);
            } else {
                $addressPayload['user_id'] = $user->id;
                \App\Models\Address::create($addressPayload);
            }
        }

        \App\Services\AuditLogger::log(
            action: 'id_verification_submitted',
            description: "User {$user->name} ({$user->role}) submitted ID & Location verification documents ({$validated['id_type']})",
            modelType: 'User',
            modelId: $user->id
        );

        // Notify admins
        $admins = \App\Models\User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            \App\Models\Notification::notify(
                $admin,
                'id_verification_submitted',
                'New Verification Submitted',
                "{$user->name} ({$user->role}) submitted government ID and location for review.",
                ['user_id' => $user->id, 'role' => $user->role]
            );
        }

        return redirect()->back()->with('success', 'Your Valid ID and Location details have been submitted for review. Our team will verify your account shortly.');
    }

    /**
     * Update general preferences.
     */
    public function updatePreferences(Request $request): RedirectResponse
    {
        // If server-side preferences are added, handle them here.
        return redirect()->back()->with('success', 'Preferences saved.');
    }
}
