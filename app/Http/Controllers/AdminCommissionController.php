<?php

namespace App\Http\Controllers;

use App\Models\Commission;
use App\Models\PlatformSetting;
use App\Services\AuditLogger;
use App\Services\CommissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminCommissionController extends Controller
{
    public function index(Request $request, CommissionService $commissionService)
    {
        if (!Auth::user()?->isAdmin()) {
            return redirect('/')->with('error', 'Unauthorized');
        }

        $query = Commission::with(['offer.listing', 'seller', 'buyer', 'payment'])->latest();

        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('collected_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('collected_at', '<=', $request->date_to);
        }

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('id', $search)
                    ->orWhere('offer_id', $search)
                    ->orWhereHas('seller', function ($sq) use ($search) {
                        $sq->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->orWhereHas('buyer', function ($bq) use ($search) {
                        $bq->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        $commissions = $query->paginate(15)->withQueryString();
        $stats = $commissionService->getRevenueStatistics();
        $currentRate = $commissionService->getCommissionRate();
        $cashCommissionEnabled = $commissionService->isCashCommissionEnabled();

        return view('admin.commissions.index', compact(
            'commissions',
            'stats',
            'currentRate',
            'cashCommissionEnabled'
        ));
    }

    public function updateSettings(Request $request, CommissionService $commissionService)
    {
        if (!Auth::user()?->isAdmin()) {
            return redirect('/')->with('error', 'Unauthorized');
        }

        $validated = $request->validate([
            'commission_rate_percent' => ['required', 'numeric', 'min:0', 'max:100'],
            'cash_pickup_commission_enabled' => ['required', 'boolean'],
        ]);

        $oldRate = $commissionService->getCommissionRate();
        $newRate = (float) $validated['commission_rate_percent'];

        PlatformSetting::set(
            'commission_rate_percent',
            $newRate,
            'decimal',
            [
                'group' => 'financials',
                'display_name' => 'Platform Commission Rate (%)',
                'description' => 'Global commission fee charged on marketplace sales.',
            ]
        );

        PlatformSetting::set(
            'cash_pickup_commission_enabled',
            (bool) $validated['cash_pickup_commission_enabled'],
            'boolean',
            [
                'group' => 'financials',
                'display_name' => 'Cash on Pickup Commission',
                'description' => 'Whether platform commission is deducted from seller wallet on cash deals.',
            ]
        );

        if (class_exists(AuditLogger::class)) {
            AuditLogger::log(
                'settings_updated',
                "Updated commission rate from {$oldRate}% to {$newRate}% (Cash commission enabled: " . ($validated['cash_pickup_commission_enabled'] ? 'Yes' : 'No') . ")",
                Auth::user()
            );
        }

        return redirect()->route('admin.commissions.index')
            ->with('success', "Commission settings updated successfully. Active rate: {$newRate}%.");
    }

    public function export(Request $request): StreamedResponse
    {
        if (!Auth::user()?->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        $query = Commission::with(['offer.listing', 'seller', 'buyer'])->latest();

        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('collected_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('collected_at', '<=', $request->date_to);
        }

        $fileName = 'commissions_report_' . now()->format('Ymd_His') . '.csv';

        return response()->streamDownload(function () use ($query) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, [
                'Commission ID',
                'Offer ID',
                'Listing Item',
                'Seller Name',
                'Seller Email',
                'Buyer Name',
                'Buyer Email',
                'Gross Amount (PHP)',
                'Commission Rate (%)',
                'Commission Amount (PHP)',
                'Seller Net Amount (PHP)',
                'Payment Method',
                'Status',
                'Collected At',
            ]);

            $query->chunk(100, function ($rows) use ($handle) {
                foreach ($rows as $row) {
                    fputcsv($handle, [
                        $row->id,
                        $row->offer_id,
                        $row->offer?->listing?->title ?? 'N/A',
                        $row->seller?->name ?? 'N/A',
                        $row->seller?->email ?? 'N/A',
                        $row->buyer?->name ?? 'N/A',
                        $row->buyer?->email ?? 'N/A',
                        number_format($row->gross_amount, 2, '.', ''),
                        number_format($row->commission_rate, 2, '.', ''),
                        number_format($row->commission_amount, 2, '.', ''),
                        number_format($row->seller_net_amount, 2, '.', ''),
                        strtoupper($row->payment_method),
                        ucfirst($row->status),
                        $row->collected_at?->format('Y-m-d H:i:s') ?? '',
                    ]);
                }
            });

            fclose($handle);
        }, $fileName, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
        ]);
    }
}
