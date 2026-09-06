<?php

namespace App\Http\Controllers;

use App\Models\PayoutRequest;
use App\Models\SellerWallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminPayoutController extends Controller
{
    public function index(Request $request)
    {
        $query = PayoutRequest::with(['seller', 'wallet'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $payouts = $query->paginate(15);

        return view('admin.payouts.index', compact('payouts'));
    }

    public function approve(PayoutRequest $payout)
    {
        if ($payout->status !== 'pending') {
            return redirect()->back()->with('error', 'Only pending payouts can be approved.');
        }

        $payout->update([
            'status' => 'approved',
            'approved_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Payout approved.');
    }

    public function markPaid(PayoutRequest $payout)
    {
        if (!in_array($payout->status, ['pending', 'approved'], true)) {
            return redirect()->back()->with('error', 'This payout cannot be marked paid.');
        }

        DB::transaction(function () use ($payout) {
            $wallet = SellerWallet::whereKey($payout->seller_wallet_id)->lockForUpdate()->firstOrFail();
            $amount = (float) $payout->amount;

            $wallet->pending_balance = max(0, (float) $wallet->pending_balance - $amount);
            $wallet->paid_out_balance = (float) $wallet->paid_out_balance + $amount;
            $wallet->save();

            $payout->update([
                'status' => 'paid',
                'approved_at' => $payout->approved_at ?: now(),
                'paid_at' => now(),
            ]);

            $wallet->transactions()->create([
                'payout_request_id' => $payout->id,
                'type' => 'payout_paid',
                'amount' => -$amount,
                'balance_after' => $wallet->available_balance,
                'status' => 'posted',
                'description' => 'Payout request #' . $payout->id . ' marked paid',
            ]);
        });

        return redirect()->back()->with('success', 'Payout marked as paid.');
    }

    public function reject(Request $request, PayoutRequest $payout)
    {
        if ($payout->status !== 'pending') {
            return redirect()->back()->with('error', 'Only pending payouts can be rejected.');
        }

        $validated = $request->validate([
            'admin_notes' => ['nullable', 'string', 'max:1000'],
        ]);

        DB::transaction(function () use ($payout, $validated) {
            $wallet = SellerWallet::whereKey($payout->seller_wallet_id)->lockForUpdate()->firstOrFail();
            $amount = (float) $payout->amount;

            $wallet->pending_balance = max(0, (float) $wallet->pending_balance - $amount);
            $wallet->available_balance = (float) $wallet->available_balance + $amount;
            $wallet->save();

            $payout->update([
                'status' => 'rejected',
                'admin_notes' => $validated['admin_notes'] ?? null,
                'rejected_at' => now(),
            ]);

            $wallet->transactions()->create([
                'payout_request_id' => $payout->id,
                'type' => 'payout_release',
                'amount' => $amount,
                'balance_after' => $wallet->available_balance,
                'status' => 'posted',
                'description' => 'Payout request #' . $payout->id . ' returned to wallet',
            ]);
        });

        return redirect()->back()->with('success', 'Payout rejected and funds returned.');
    }
}
