@extends('layouts.app')

@section('title', 'Model Audit Logs - E-Benta')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Audit Logs for {{ $modelType }} #{{ $modelId }}</h1>
    @forelse($logs as $log)
        <article class="card mb-3">
            <div class="card-body">
                <h2 class="h6">{{ $log->getActionLabel() }}</h2>
                <p class="mb-1">{{ $log->description }}</p>
                <small class="text-muted">{{ $log->created_at?->format('M d, Y g:i A') }}</small>
            </div>
        </article>
    @empty
        <p>No audit logs found.</p>
    @endforelse
    {{ $logs->links() }}
</div>
@endsection
