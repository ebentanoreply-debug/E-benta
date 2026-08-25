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
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        // Take action based on selection
        match($validated['action_taken']) {
            'user_suspended' => $this->suspendUser($report),
            'user_banned' => $this->banUser($report),
            'listing_removed' => $this->removeListing($report),
            default => null
        };

        $report->resolve(Auth::id(), $validated['action_taken'], $validated['admin_notes']);

        return redirect()->back()->with('success', 'Report resolved');
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
     * Suspend user account.
     */
    private function suspendUser(Report $report)
    {
        if ($report->reportable instanceof User) {
            $report->reportable->update(['is_suspended' => true]);
        }
    }

    /**
     * Ban user account.
     */
    private function banUser(Report $report)
    {
        if ($report->reportable instanceof User) {
            $report->reportable->update(['is_banned' => true]);
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
