@extends('layouts.app')

@section('title', 'Payout Requests - Admin - E-Benta')

@section('content')
@include('admin.sidebar')

<div class="main-content-wrapper" style="margin-left:260px; width:calc(100% - 260px);">
    <div style="background:#f8fafc; min-height:100vh; padding:2rem;">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            <div>
                <h1 class="fw-bold mb-1">Payout Requests</h1>
                <p class="text-muted mb-0">Approve requests and mark seller payouts as paid after transfer.</p>
            </div>
            <form method="GET" class="d-flex gap-2">
                <select name="status" class="form-select">
                    <option value="">All statuses</option>
                    @foreach(['pending', 'approved', 'paid', 'rejected'] as $status)
                        <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
                <button class="btn btn-dark">Filter</button>
            </form>
        </div>

        <div class="bg-white border rounded-3">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Seller</th>
                            <th>Amount</th>
                            <th>Destination</th>
                            <th>Status</th>
                            <th>Requested</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payouts as $payout)
                            <tr>
                                <td>#{{ $payout->id }}</td>
                                <td>
                                    <strong>{{ $payout->seller->name }}</strong>
                                    <div class="text-muted small">{{ $payout->seller->email }}</div>
                                </td>
                                <td><strong>₱{{ number_format($payout->amount, 2) }}</strong></td>
                                <td>{{ ucfirst($payout->destination_type) }}<div class="text-muted small">{{ $payout->destination_label ?: 'No saved details' }}</div></td>
                                <td><span class="badge bg-secondary">{{ ucfirst($payout->status) }}</span></td>
                                <td>{{ $payout->requested_at?->format('M d, Y') ?: $payout->created_at->format('M d, Y') }}</td>
                                <td class="text-end">
                                    @if($payout->status === 'pending')
                                        <form method="POST" action="{{ route('admin.payouts.approve', $payout) }}" class="d-inline">@csrf<button class="btn btn-sm btn-outline-primary">Approve</button></form>
                                        <form method="POST" action="{{ route('admin.payouts.reject', $payout) }}" class="d-inline">@csrf<button class="btn btn-sm btn-outline-danger">Reject</button></form>
                                    @endif
                                    @if(in_array($payout->status, ['pending', 'approved']))
                                        <form method="POST" action="{{ route('admin.payouts.mark-paid', $payout) }}" class="d-inline">@csrf<button class="btn btn-sm btn-success">Mark Paid</button></form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center text-muted py-5">No payout requests found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-3">{{ $payouts->links() }}</div>
    </div>
</div>
@endsection
