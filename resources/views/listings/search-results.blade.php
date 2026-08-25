@extends('layouts.app')

@section('title', 'Search Results - E-Benta')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Search Results</h1>
    @forelse($listings as $listing)
        <article class="card mb-3">
            <div class="card-body">
                <h2 class="h5">{{ $listing->deviceType?->name ?? 'Device' }}</h2>
                <p class="mb-2">{{ $listing->description }}</p>
                <p class="fw-bold">Seller's asking price: ₱{{ number_format($listing->suggested_price, 2) }}</p>
                <a href="{{ route('listings.show', $listing) }}" class="btn btn-primary">View Listing</a>
            </div>
        </article>
    @empty
        <p>No listings match your search.</p>
    @endforelse
    {{ $listings->withQueryString()->links() }}
</div>
@endsection
