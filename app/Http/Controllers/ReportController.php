<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Listing;
use App\Models\Offer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\AuditLogger;

class ReportController extends Controller
{
    /**
     * Show the form to report a listing, offer, or user.
     */
    public function create(Request $request)
    {
        $type = $request->query('type'); // 'listing', 'offer', 'user'
        $id = $request->query('id');

        // Validate required parameters
        if (!$type || !$id) {
            return redirect()->back()->with('error', 'Invalid report request');
        }

        // Verify the item exists
        $item = match($type) {
            'listing' => Listing::find($id),
            'offer' => Offer::find($id),
            'user' => User::find($id),
            default => null
        };

        if (!$item) {
            return redirect()->back()->with('error', 'Item not found');
        }

        $reportableType = match ($type) {
            'listing' => Listing::class,
            'offer' => Offer::class,
            'user' => User::class,
        };

        $duplicate = Report::where('user_id', Auth::id())
            ->where('reportable_type', $reportableType)
            ->where('reportable_id', $id)
            ->where('status', '!=', 'dismissed')
            ->exists();

        if ($duplicate) {
            return redirect()->back()->with('warning', 'You have already reported this item');
        }

        // Check if user already reported this
        $existingReport = Report::where('user_id', Auth::id())
            ->where('reportable_type', "App\\Models\\" . ucfirst($type))
            ->where('reportable_id', $id)
            ->where('status', '!=', 'dismissed')
            ->first();

        if ($existingReport) {
            return redirect()->back()->with('warning', 'You have already reported this item');
        }

        $reasons = [
            'inappropriate_content' => 'Inappropriate Content',
            'scam_fraud' => 'Scam or Fraud',
            'offensive_language' => 'Offensive Language',
            'harassment_abuse' => 'Harassment or Abuse',
            'spam' => 'Spam',
            'false_information' => 'False Information',
            'fake_listing' => 'Fake Listing',
            'broken_item_misrepresentation' => 'Broken Item/Misrepresentation',
            'seller_unresponsive' => 'Seller Unresponsive',
            'suspicious_behavior' => 'Suspicious Behavior',
            'other' => 'Other',
        ];

        return view('reports.create', compact('type', 'id', 'item', 'reasons'));
    }

    /**
     * Store a new report.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:listing,offer,user',
            'id' => 'required|integer|min:1',
            'reason' => 'required|string|in:inappropriate_content,scam_fraud,offensive_language,harassment_abuse,spam,false_information,fake_listing,broken_item_misrepresentation,seller_unresponsive,suspicious_behavior,other',
            'description' => 'required|string|min:10|max:1000',
        ]);

        // Verify the item exists
        $item = match($validated['type']) {
            'listing' => Listing::find($validated['id']),
            'offer' => Offer::find($validated['id']),
            'user' => User::find($validated['id']),
            default => null
        };

        if (!$item) {
            return redirect()->back()->with('error', 'Item not found');
        }

        // Check if user is trying to report themselves
        if ($validated['type'] === 'user' && $validated['id'] == Auth::id()) {
            return redirect()->back()->with('error', 'You cannot report yourself');
        }

        $reportableType = match ($validated['type']) {
            'listing' => Listing::class,
            'offer' => Offer::class,
            'user' => User::class,
        };

        $duplicate = Report::where('user_id', Auth::id())
            ->where('reportable_type', $reportableType)
            ->where('reportable_id', $validated['id'])
            ->where('status', '!=', 'dismissed')
            ->exists();

        if ($duplicate) {
            return redirect()->back()->with('warning', 'You have already reported this item');
        }

        // Create the report
        $report = Report::create([
            'user_id' => Auth::id(),
            'reportable_type' => $reportableType,
            'reportable_id' => $validated['id'],
            'reason' => $validated['reason'],
            'description' => $validated['description'],
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Thank you for reporting. Our team will review your report.');
    }

    /**
     * Show admin report list (admin only).
     */
    public function index(Request $request)
    {
        // Verify admin
        if (!Auth::user()->isAdmin()) {
            return redirect('/')->with('error', 'Unauthorized');
        }

        $query = Report::with(['reporter', 'reviewer', 'reportable']);

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter by reason
        if ($request->has('reason') && $request->reason) {
            $query->where('reason', $request->reason);
        }

        // Filter by type
        if ($request->has('type') && $request->type) {
            $query->where('reportable_type', "App\\Models\\" . ucfirst($request->type));
        }

        // Search in description
        if ($request->has('search') && $request->search) {
            $query->where('description', 'like', '%' . $request->search . '%');
        }

        $reports = $query->newest()->paginate(20);

        return view('admin.reports.index', compact('reports'));
    }

    /**
     * Show report details (admin only).
     */
    public function show(Report $report)
    {
        // Verify admin
        if (!Auth::user()->isAdmin()) {
            return redirect('/')->with('error', 'Unauthorized');
        }

        $report->load(['reporter', 'reviewer', 'reportable']);

        return view('admin.reports.show', compact('report'));
    }

    /**
     * Mark report as under review.
     */
    public function markUnderReview(Report $report)
    {
        // Verify admin
        if (!Auth::user()->isAdmin()) {
            return redirect('/')->with('error', 'Unauthorized');
        }

        $report->markUnderReview(Auth::id());

        return redirect()->back()->with('success', 'Report marked as under review');
    }

    /**
     * Resolve a report.
     */
    public function resolve(Request $request, Report $report)
    {
        // Verify admin
        if (!Auth::user()->isAdmin()) {
            return redirect('/')->with('error', 'Unauthorized');
        }

        $validated = $request->validate([
            'action_taken' => 'required|in:none,warning_sent,content_removed,user_suspended,user_banned,listing_removed',
            'suspension_days' => 'nullable|integer|min:1|max:365',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $days = !empty($validated['suspension_days']) ? (int) $validated['suspension_days'] : null;

        // Take action based on selection
        match($validated['action_taken']) {
            'user_suspended' => $this->suspendUser($report, $days),
            'warning_sent' => $this->warnUser($report, $validated['admin_notes'] ?? null),
            'user_banned' => $this->banUser($report),
            'content_removed', 'listing_removed' => $this->removeContent($report),
            default => null
        };

        $report->resolve(Auth::id(), $validated['action_taken'], $validated['admin_notes']);

        return redirect()->back()->with('success', 'Report resolved successfully');
    }

    /**
     * Dismiss a report.
     */
    public function dismiss(Request $request, Report $report)
    {
        // Verify admin
        if (!Auth::user()->isAdmin()) {
            return redirect('/')->with('error', 'Unauthorized');
        }

        $validated = $request->validate([
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $report->dismiss(Auth::id(), $validated['admin_notes']);

        return redirect()->back()->with('success', 'Report dismissed');
    }

    /**
     * Find target user from reportable object.
     */
    private function getTargetUser(Report $report): ?User
    {
        if ($report->reportable instanceof User) {
            return $report->reportable;
        }
        if ($report->reportable instanceof Listing) {
            return $report->reportable->seller;
        }
        if ($report->reportable instanceof Offer) {
            return $report->reportable->buyer;
        }
        if ($report->reportable instanceof \App\Models\Review) {
            return $report->reportable->reviewer;
        }
        return null;
    }

    /**
     * Warn user account. Auto-bans if warning count reaches 3.
     */
    private function warnUser(Report $report, ?string $adminNotes = null)
    {
        $targetUser = $this->getTargetUser($report);
        if (!$targetUser) {
            return;
        }

        $result = $targetUser->addWarning($adminNotes);
        $warningCount = $result['warning_count'];
        $isBanned = $result['is_banned'];

        if ($isBanned) {
            \App\Models\Notification::notify(
                $targetUser,
                'account_banned',
                'Account Banned 🚫',
                "Your account has been automatically banned after reaching 3 disciplinary warnings. Reason: " . ($adminNotes ?: 'Repeated policy violations'),
                ['warning_count' => 3, 'banned_at' => now()]
            );
        } else {
            \App\Models\Notification::notify(
                $targetUser,
                'account_warning',
                "Warning Notice ({$warningCount}/3) ⚠️",
                "You have received warning #{$warningCount} of 3. Note: " . ($adminNotes ?: 'Please adhere to E-Benta platform guidelines.') . " Note: Reaching 3 warnings will result in an automatic permanent account ban.",
                ['warning_count' => $warningCount, 'admin_notes' => $adminNotes]
            );
        }

        AuditLogger::log(
            action: 'warn_user',
            description: "Admin " . Auth::user()->name . " issued warning #{$warningCount} to user {$targetUser->name}" . ($isBanned ? ' (auto-banned)' : ''),
            modelType: 'User',
            modelId: $targetUser->id,
            newValues: ['warning_count' => $warningCount, 'is_banned' => $isBanned]
        );
    }

    /**
     * Suspend user account with optional days.
     */
    private function suspendUser(Report $report, ?int $days = null)
    {
        $targetUser = $this->getTargetUser($report);
        if (!$targetUser) {
            return;
        }

        $targetUser->suspendForDays($days);
        $suspensionText = $days ? "for {$days} days (until " . now()->addDays($days)->format('M d, Y') . ")" : "indefinitely";

        \App\Models\Notification::notify(
            $targetUser,
            'account_suspended',
            'Account Suspended ⏸️',
            "Your account has been suspended {$suspensionText}. Please contact support for inquiries.",
            ['suspended_until' => $targetUser->suspended_until]
        );

        AuditLogger::log(
            action: 'suspend_user',
            description: "Admin " . Auth::user()->name . " suspended user {$targetUser->name} {$suspensionText}",
            modelType: 'User',
            modelId: $targetUser->id,
            newValues: ['is_suspended' => true, 'suspended_until' => $targetUser->suspended_until]
        );
    }

    /**
     * Ban user account permanently.
     */
    private function banUser(Report $report)
    {
        $targetUser = $this->getTargetUser($report);
        if ($targetUser) {
            $targetUser->update(['is_banned' => true]);

            \App\Models\Notification::notify(
                $targetUser,
                'account_banned',
                'Account Banned 🚫',
                'Your account has been permanently banned due to violation of platform policies.',
                ['banned_at' => now()]
            );

            AuditLogger::log(
                action: 'ban_user',
                description: "Admin " . Auth::user()->name . " banned user {$targetUser->name}",
                modelType: 'User',
                modelId: $targetUser->id,
                newValues: ['is_banned' => true]
            );
        }
    }

    /**
     * Remove content / listing reported.
     */
    private function removeContent(Report $report)
    {
        if ($report->reportable instanceof Listing) {
            $this->removeListing($report);
        } elseif ($report->reportable instanceof \App\Models\Review) {
            $review = $report->reportable;
            $review->delete();
            AuditLogger::log(
                action: 'moderate_review',
                description: "Review #{$review->id} removed by Admin after report resolution",
                modelType: 'Review',
                modelId: $review->id
            );
        } elseif ($report->reportable instanceof User) {
            Listing::where('user_id', $report->reportable->id)
                ->whereIn('status', ['pending', 'available'])
                ->update(['status' => 'withdrawn']);
        }
    }

    /**
     * Remove listing.
     */
    private function removeListing(Report $report)
    {
        if ($report->reportable instanceof Listing) {
            $listing = $report->reportable;
            $previousStatus = $listing->status;
            $listing->update(['status' => 'withdrawn']);

            // Notify seller
            if ($listing->seller) {
                \App\Models\Notification::notify(
                    $listing->seller,
                    'listing_removed',
                    'Listing Removed by Admin ⚠️',
                    "Your listing #{$listing->id} ({$listing->device_details}) was withdrawn by moderators following a report.",
                    ['listing_id' => $listing->id]
                );
            }

            AuditLogger::log(
                action: 'moderate_listing',
                description: "Listing #{$listing->id} withdrawn after report resolution",
                modelType: 'Listing',
                modelId: $listing->id,
                oldValues: ['status' => $previousStatus],
                newValues: ['status' => 'withdrawn']
            );
        }
    }

    /**
     * Get report statistics (admin API endpoint).
     */
    public function statistics()
    {
        if (!Auth::user()->isAdmin()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $stats = [
            'total' => Report::count(),
            'pending' => Report::pending()->count(),
            'under_review' => Report::underReview()->count(),
            'resolved' => Report::resolved()->count(),
            'dismissed' => Report::where('status', 'dismissed')->count(),
            'recent_30_days' => Report::recent(30)->count(),
            'by_reason' => Report::select('reason')
                ->selectRaw('count(*) as count')
                ->groupBy('reason')
                ->get()
                ->pluck('count', 'reason'),
            'by_type' => Report::select('reportable_type')
                ->selectRaw('count(*) as count')
                ->groupBy('reportable_type')
                ->get()
                ->mapWithKeys(fn ($item) => [
                    class_basename($item->reportable_type) => $item->count
                ]),
        ];

        return response()->json($stats);
    }
}
