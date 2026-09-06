<?php

namespace App\Http\Controllers;

use App\Services\SellerWalletService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerWalletController extends Controller
{
    public function index(SellerWalletService $wallets)
    {
        $wallet = $wallets->walletForSeller(Auth::id());
        $transactions = $wallet->transactions()->latest()->paginate(12);
        $payouts = $wallet->payoutRequests()->latest()->limit(8)->get();
        $minimumPayout = (float) config('services.paymongo.minimum_payout', 1500);
        $canRequestPayout = now()->isSaturday() || (float) $wallet->available_balance >= $minimumPayout;

        return view('seller.wallet', compact('wallet', 'transactions', 'payouts', 'minimumPayout', 'canRequestPayout'));
    }

    public function requestPayout(Request $request, SellerWalletService $wallets)
    {
        $wallet = $wallets->walletForSeller(Auth::id());
        $minimumPayout = (float) config('services.paymongo.minimum_payout', 1500);
        $isEligible = now()->isSaturday() || (float) $wallet->available_balance >= $minimumPayout;

        if (!$isEligible) {
            return redirect()->back()->with('error', 'Payouts are available every Saturday or once your wallet reaches ₱' . number_format($minimumPayout, 2) . '.');
        }

        $validated = $request->validate([
            'amount' => ['required', 'numeric', 'min:1', 'max:' . (float) $wallet->available_balance],
            'destination_type' => ['required', 'in:gcash,bank'],
        ]);

        $destinationLabel = $validated['destination_type'] === 'bank'
            ? trim((Auth::user()->bank_name ?: 'Bank') . ' ' . (Auth::user()->bank_account_number ?: ''))
            : Auth::user()->gcash_number;

        $wallets->requestPayout($wallet, (float) $validated['amount'], $validated['destination_type'], $destinationLabel);

        return redirect()->route('seller.wallet')->with('success', 'Payout request submitted for admin processing.');
    }
}
