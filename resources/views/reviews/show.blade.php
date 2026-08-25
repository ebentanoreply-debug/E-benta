@extends('layouts.app')

@section('title', 'Review - E-Benta')

@section('content')
<div class="container py-4">
    <article class="card">
        <div class="card-body">
            <h1 class="h4">{{ $review->title }}</h1>
            <p class="text-warning mb-2">{{ $review->getStarRating() }}</p>
            <p>{{ $review->comment ?: 'No comment provided.' }}</p>
            <p class="text-muted mb-0">By {{ $review->reviewer?->name ?? 'Unknown user' }} for {{ $review->reviewee?->name ?? 'Unknown user' }}</p>
        </div>
    </article>
</div>
@endsection
