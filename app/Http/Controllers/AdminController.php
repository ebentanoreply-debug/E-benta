<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Listing;
use App\Models\Offer;
use App\Models\ImpactLog;
use App\Models\Notification;
use App\Services\AuditLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Show admin dashboard.
     */
    public function dashboard()
    {
        // Ensure user is admin
        if (!Auth::user()->isAdmin()) {
            return redirect('/')->with('error', 'Unauthorized');
        }

        $impactController = new ImpactController();
        $analytics = $impactController->getAdminAnalytics();

        $recentTransactions = ImpactLog::with(['seller', 'buyer', 'listing'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $pendingVerifications = User::where('role', 'buyer')
            ->where('is_verified', false)
            ->with('offers')
            ->paginate(10);

        $totalUsers = User::count();
        $totalListings = Listing::count();
        $totalOffers = Offer::count();
        $totalTransactions = ImpactLog::count();

        return view('admin.dashboard', compact(
            'analytics',
            'recentTransactions',
            'pendingVerifications',
            'totalUsers',
            'totalListings',
            'totalOffers',
            'totalTransactions'
        ));
    }

    /**
    * Show pending buyer verifications.
     */
    public function pendingVerifications()
    {
        if (!Auth::user()->isAdmin()) {
            return redirect('/')->with('error', 'Unauthorized');
        }

        $pendingUsers = User::where('role', 'buyer')
            ->where('is_verified', false)
            ->paginate(15);

        return view('admin.pending-verifications', compact('pendingUsers'));
    }

    /**
     * Verify a buyer/recycler account.
     */
    public function verifyUser(User $user)
    {
        if (!Auth::user()->isAdmin()) {
            return redirect('/')->with('error', 'Unauthorized');
        }

        if ($user->role !== 'buyer') {
            return redirect()->back()
                ->with('error', 'Only buyers can be verified');
        }

        $user->update(['is_verified' => true]);

        // Log account approval
        AuditLogger::logAccountApproval(
            $user->id,
            'approved',
            "Admin " . Auth::user()->name . " approved account"
        );

        // Send notification to buyer - account approved
        Notification::notify(
            $user,
            'account_approved',
            'Account Approved! 🎉',
            'Congratulations! Your account has been approved. You can now browse listings and submit offers.',
            ['verified_at' => now()]
        );

        return redirect()->route('admin.pending-verifications')
            ->with('success', 'User account verified successfully');
    }

    /**
     * Reject a buyer/recycler account.
     */
    public function rejectUser(Request $request, User $user)
    {
        if (!Auth::user()->isAdmin()) {
            return redirect('/')->with('error', 'Unauthorized');
        }

        $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        // Log account rejection
        AuditLogger::logAccountApproval(
            $user->id,
            'rejected',
            "Admin " . Auth::user()->name . " rejected account. Reason: " . $request->reason
        );

        // Send rejection notification to user with reason
        Notification::notify(
            $user,
            'account_rejected',
            'Account Registration Rejected',
            'Your account registration has been rejected. Reason: ' . $request->reason,
            ['rejection_reason' => $request->reason]
        );

        // Optionally delete the user or mark it differently
        $user->delete();

        return redirect()->route('admin.pending-verifications')
            ->with('success', 'User account rejected and notification sent');
    }

    /**
     * View all listings.
     */
    public function allListings(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            return redirect('/')->with('error', 'Unauthorized');
        }

        $query = Listing::with(['seller', 'offers']);

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $listings = $query->paginate(15);

        return view('admin.listings', compact('listings'));
    }

    /**
     * View all offers.
     */
    public function allOffers(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            return redirect('/')->with('error', 'Unauthorized');
        }

        $query = Offer::with(['listing', 'buyer', 'listing.seller']);

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $offers = $query->paginate(15);

        return view('admin.offers', compact('offers'));
    }

    /**
     * View impact logs and certifications.
     */
    public function impactLogs(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            return redirect('/')->with('error', 'Unauthorized');
        }

        $query = ImpactLog::with(['seller', 'buyer', 'listing']);

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $logs = $query->paginate(15);

        return view('admin.impact-logs', compact('logs'));
    }

    /**
     * Generate system reports.
     */
    public function generateReport(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            return redirect('/')->with('error', 'Unauthorized');
        }

        $reportType = $request->get('type', 'monthly');

        $data = match ($reportType) {
            'monthly' => $this->generateMonthlyReport(),
            'quarterly' => $this->generateQuarterlyReport(),
            'yearly' => $this->generateYearlyReport(),
            default => $this->generateMonthlyReport(),
        };

        return view('admin.reports', compact('data', 'reportType'));
    }

    /**
     * Generate monthly report.
     */
    private function generateMonthlyReport(): array
    {
        $startDate = now()->startOfMonth();
        $endDate = now()->endOfMonth();

        return [
            'period' => $startDate->format('M Y'),
            'total_items' => Listing::whereBetween('created_at', [$startDate, $endDate])->count(),
            'total_transactions' => ImpactLog::whereBetween('created_at', [$startDate, $endDate])->count(),
            'total_co2_saved' => ImpactLog::whereBetween('created_at', [$startDate, $endDate])->sum('co2_saved'),
            'total_waste_diverted' => ImpactLog::whereBetween('created_at', [$startDate, $endDate])->sum('landfill_diverted_weight'),
            'new_sellers' => User::where('role', 'seller')->whereBetween('created_at', [$startDate, $endDate])->count(),
            'new_buyers' => User::where('role', 'buyer')->whereBetween('created_at', [$startDate, $endDate])->count(),
            'verified_buyers' => User::where('role', 'buyer')->where('is_verified', true)->count(),
        ];
    }

    /**
     * Generate quarterly report.
     */
    private function generateQuarterlyReport(): array
    {
        $quarter = ceil(now()->month / 3);
        $startMonth = ($quarter - 1) * 3 + 1;
        $startDate = now()->createFromDate(now()->year, $startMonth, 1)->startOfMonth();
        $endDate = $startDate->clone()->addMonths(3)->endOfMonth();

        return [
            'period' => 'Q' . $quarter . ' ' . now()->year,
            'total_items' => Listing::whereBetween('created_at', [$startDate, $endDate])->count(),
            'total_transactions' => ImpactLog::whereBetween('created_at', [$startDate, $endDate])->count(),
            'total_co2_saved' => ImpactLog::whereBetween('created_at', [$startDate, $endDate])->sum('co2_saved'),
            'total_waste_diverted' => ImpactLog::whereBetween('created_at', [$startDate, $endDate])->sum('landfill_diverted_weight'),
            'new_sellers' => User::where('role', 'seller')->whereBetween('created_at', [$startDate, $endDate])->count(),
            'new_buyers' => User::where('role', 'buyer')->whereBetween('created_at', [$startDate, $endDate])->count(),
        ];
    }

    /**
     * Generate yearly report.
     */
    private function generateYearlyReport(): array
    {
        $startDate = now()->startOfYear();
        $endDate = now()->endOfYear();

        return [
            'period' => now()->year,
            'total_items' => Listing::whereBetween('created_at', [$startDate, $endDate])->count(),
            'total_transactions' => ImpactLog::whereBetween('created_at', [$startDate, $endDate])->count(),
            'total_co2_saved' => ImpactLog::whereBetween('created_at', [$startDate, $endDate])->sum('co2_saved'),
            'total_waste_diverted' => ImpactLog::whereBetween('created_at', [$startDate, $endDate])->sum('landfill_diverted_weight'),
            'new_sellers' => User::where('role', 'seller')->whereBetween('created_at', [$startDate, $endDate])->count(),
            'new_buyers' => User::where('role', 'buyer')->whereBetween('created_at', [$startDate, $endDate])->count(),
        ];
    }

    /**
     * Get system statistics.
     */
    public function getStatistics()
    {
        if (!Auth::user()->isAdmin()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json([
            'total_users' => User::count(),
            'total_sellers' => User::where('role', 'seller')->count(),
            'total_buyers' => User::where('role', 'buyer')->count(),
            'verified_buyers' => User::where('role', 'buyer')->where('is_verified', true)->count(),
            'total_listings' => Listing::count(),
            'active_listings' => Listing::where('status', 'available')->count(),
            'total_offers' => Offer::count(),
            'pending_offers' => Offer::where('status', 'pending')->count(),
            'total_transactions' => ImpactLog::count(),
            'total_co2_saved' => ImpactLog::sum('co2_saved'),
            'total_waste_diverted' => ImpactLog::sum('landfill_diverted_weight'),
        ]);
    }

    /**
     * Export dashboard report as CSV.
     */
    public function exportDashboardReport()
    {
        if (!Auth::user()->isAdmin()) {
            return redirect('/')->with('error', 'Unauthorized');
        }

        // Get the same analytics data as the dashboard
        $impactController = new ImpactController();
        $analytics = $impactController->getAdminAnalytics();

        // Get additional data
        $totalUsers = User::count();
        $totalListings = Listing::count();
        $totalOffers = Offer::count();
        $totalTransactions = ImpactLog::count();
        $verifiedBuyers = User::where('role', 'buyer')->where('is_verified', true)->count();
        $activeSellers = User::where('role', 'seller')->where('is_verified', true)->count();

        // Create CSV content
        $csv = "E-BENTA ADMIN DASHBOARD REPORT\n";
        $csv .= "Generated: " . now()->format('Y-m-d H:i:s') . "\n\n";

        $csv .= "=== SYSTEM OVERVIEW ===\n";
        $csv .= "Total Users," . $totalUsers . "\n";
        $csv .= "Active Sellers," . $activeSellers . "\n";
        $csv .= "Verified Buyers," . $verifiedBuyers . "\n";
        $csv .= "Total Listings," . $totalListings . "\n";
        $csv .= "Total Offers," . $totalOffers . "\n";
        $csv .= "Total Transactions," . $totalTransactions . "\n\n";

        $csv .= "=== ENVIRONMENTAL IMPACT ===\n";
        $csv .= "Total E-waste Collected (kg)," . number_format($analytics['total_waste_diverted'] ?? 0, 2) . "\n";
        $csv .= "Total E-waste Collected (tons)," . number_format(($analytics['total_waste_diverted'] ?? 0) / 1000, 2) . "\n";
        $csv .= "Carbon Emissions Reduced (kg)," . number_format($analytics['total_co2_saved'] ?? 0, 2) . "\n";
        $csv .= "Carbon Emissions Reduced (metric tons)," . number_format(($analytics['total_co2_saved'] ?? 0) / 1000, 2) . "\n";
        $csv .= "Materials Recovered (kg)," . number_format($analytics['total_materials_recovered'] ?? 0, 2) . "\n\n";

        $csv .= "=== MATERIAL BREAKDOWN ===\n";
        $csv .= "Gold Recovered (grams)," . number_format($analytics['total_gold'] ?? 0, 2) . "\n";
        $csv .= "Copper Recovered (grams)," . number_format($analytics['total_copper'] ?? 0, 2) . "\n";
        $csv .= "Plastic Recovered (grams)," . number_format($analytics['total_plastic'] ?? 0, 2) . "\n";
        $csv .= "Aluminum Recovered (grams)," . number_format($analytics['total_aluminum'] ?? 0, 2) . "\n";
        $csv .= "Rare Earth Elements Recovered (grams)," . number_format($analytics['total_rare_earth'] ?? 0, 2) . "\n";

        // Return as download
        $filename = 'E-Benta_Dashboard_Report_' . now()->format('Y-m-d_H-i-s') . '.csv';
        
        return response($csv, 200, [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }
}
