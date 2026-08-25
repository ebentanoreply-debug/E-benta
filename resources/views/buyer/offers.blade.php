@extends('layouts.app')

@section('title', 'My Offers - E-Benta')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">My Offers</h1>
    @forelse($offers as $offer)
        <article class="card mb-3">
            <div class="card-body">
                <h2 class="h5">{{ $offer->listing?->deviceType?->name ?? 'Listing' }}</h2>
                <p class="mb-2">Offer: ₱{{ number_format($offer->bid_amount, 2) }}</p>
                <p class="text-muted">Status: {{ ucfirst($offer->status) }}</p>
                @if($offer->listing)
                    <a href="{{ route('offers.show', $offer) }}" class="btn btn-primary">View Offer</a>
                @endif
            </div>
        </article>
    @empty
        <p>No {{ $status }} offers found.</p>
    @endforelse
    {{ $offers->withQueryString()->links() }}
</div>
@endsection
