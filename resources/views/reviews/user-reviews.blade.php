@extends('layouts.app')

@section('title', 'Reviews for ' . $user->name . ' - E-Benta')

@section('content')
<div class="container py-4">
    <h1 class="mb-2">Reviews for {{ $user->name }}</h1>
    <p class="text-muted">{{ number_format($averageRating, 1) }}/5 from {{ $totalReviews }} reviews</p>
    @forelse($reviews as $review)
        <article class="card mb-3">
            <div class="card-body">
                <h2 class="h5">{{ $review->title }}</h2>
                <p class="text-warning">{{ $review->getStarRating() }}</p>
                <p>{{ $review->comment ?: 'No comment provided.' }}</p>
                <a href="{{ route('reviews.show', $review) }}" class="btn btn-outline-primary">View Review</a>
            </div>
        </article>
    @empty
        <p>No reviews yet.</p>
    @endforelse
    {{ $reviews->links() }}
</div>
@endsection
