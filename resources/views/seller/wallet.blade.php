@extends('layouts.app')

@section('title', 'Seller Wallet - E-Benta')

@section('content')
@include('seller.sidebar')

<div class="main-content-wrapper">
    <div style="background:#f8fafc; min-height:100vh; padding-bottom:4rem;">
        <div style="background:#09171f; color:#fff; padding:2rem 0; border-bottom:1px solid rgba(13,148,136,.25);">
            <div class="container-fluid px-3 px-md-4">
                <h1 style="font-weight:900; margin:0;">Seller Wallet</h1>
                <p style="color:#94a3b8; margin:.35rem 0 0;">Track paid sales and request payouts.</p>
            </div>
        </div>

        <div class="container-fluid px-3 px-md-4 mt-4">
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="bg-white border rounded-3 p-4">
                        <small class="text-muted fw-bold text-uppercase">Available</small>
                        <h2 class="fw-bold text-success mb-0">₱{{ number_format($wallet->available_balance, 2) }}</h2>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="bg-white border rounded-3 p-4">
                        <small class="text-muted fw-bold text-uppercase">Pending Payout</small>
                        <h2 class="fw-bold text-warning mb-0">₱{{ number_format($wallet->pending_balance, 2) }}</h2>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="bg-white border rounded-3 p-4">
                        <small class="text-muted fw-bold text-uppercase">Paid Out</small>
                        <h2 class="fw-bold text-primary mb-0">₱{{ number_format($wallet->paid_out_balance, 2) }}</h2>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-5">
                    <div class="bg-white border rounded-3 p-4">
                        <h5 class="fw-bold mb-3"><i class="fas fa-money-bill-transfer me-2 text-success"></i>Request Payout</h5>
                        <p class="text-muted">
                            Minimum payout is ₱{{ number_format($minimumPayout, 2) }}. You can also request a payout every Saturday.
                        </p>

                        @if($canRequestPayout && (float) $wallet->available_balance > 0)
                            <form method="POST" action="{{ route('seller.payouts.request') }}">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Amount</label>
                                    <input type="number" name="amount" class="form-control" min="1" max="{{ $wallet->available_balance }}" step="0.01" value="{{ $wallet->available_balance }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Destination</label>
                                    <select name="destination_type" class="form-select" required>
                                        <option value="gcash">GCash {{ auth()->user()->gcash_number ? '(' . auth()->user()->gcash_number . ')' : '' }}</option>
                                        <option value="bank">Bank {{ auth()->user()->bank_name ? '(' . auth()->user()->bank_name . ')' : '' }}</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-success fw-bold">
                                    <i class="fas fa-paper-plane me-2"></i>Submit Request
                                </button>
                            </form>
                        @else
                            <div class="alert alert-info mb-0">
                                Payouts unlock on Saturday or when your available balance reaches ₱{{ number_format($minimumPayout, 2) }}.
                            </div>
                        @endif
                    </div>

                    <div class="bg-white border rounded-3 p-4 mt-4">
                        <h5 class="fw-bold mb-3">Recent Payout Requests</h5>
                        @forelse($payouts as $payout)
                            <div class="d-flex justify-content-between border-bottom py-2">
                                <span>#{{ $payout->id }} · {{ ucfirst($payout->status) }}</span>
                                <strong>₱{{ number_format($payout->amount, 2) }}</strong>
                            </div>
                        @empty
                            <p class="text-muted mb-0">No payout requests yet.</p>
                        @endforelse
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="bg-white border rounded-3 p-4">
                        <h5 class="fw-bold mb-3"><i class="fas fa-list me-2 text-success"></i>Wallet Ledger</h5>
                        @forelse($transactions as $transaction)
                            <div class="d-flex justify-content-between align-items-center border-bottom py-3">
                                <div>
                                    <div class="d-flex align-items-center gap-2">
                                        <strong>{{ str_replace('_', ' ', ucfirst($transaction->type)) }}</strong>
                                        @if($transaction->type === 'platform_fee')
                                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle" style="font-size: 0.7rem;">Fee</span>
                                        @elseif($transaction->type === 'sale_credit')
                                            <span class="badge bg-success-subtle text-success border border-success-subtle" style="font-size: 0.7rem;">Credit</span>
                                        @endif
                                    </div>
                                    <div class="text-muted small">{{ $transaction->description }} · {{ $transaction->created_at->format('M d, Y g:i A') }}</div>
                                </div>
                                <div class="text-end">
                                    <strong class="{{ $transaction->amount >= 0 ? 'text-success' : 'text-danger' }}">
                                        {{ $transaction->amount >= 0 ? '+' : '' }}₱{{ number_format($transaction->amount, 2) }}
                                    </strong>
                                    <div class="text-muted small">Balance ₱{{ number_format($transaction->balance_after, 2) }}</div>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted mb-0">Your wallet ledger is empty.</p>
                        @endforelse

                        <div class="mt-3">{{ $transactions->links() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
