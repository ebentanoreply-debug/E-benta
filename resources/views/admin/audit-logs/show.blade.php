@extends('layouts.app')

@section('title', 'Audit Event #' . $auditLog->id . ' - E-Benta Admin')

@section('styles')
<style>
    .admin-page-container {
        background: #f8fafc;
        min-height: 100vh;
        padding-bottom: 4rem;
    }

    body.dark-mode .admin-page-container {
        background: #09171f;
    }

    .admin-module-header {
        background: linear-gradient(135deg, #09171f 0%, #0d2833 100%);
        border-bottom: 1px solid rgba(13, 148, 136, 0.25);
        color: #ffffff;
        padding: 2.25rem 0 2rem;
        position: relative;
        overflow: hidden;
    }

    .admin-card {
        background: #ffffff;
        border: 1px solid rgba(13, 148, 136, 0.15);
        border-radius: 1.25rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        overflow: hidden;
    }

    body.dark-mode .admin-card {
        background: #0f232d;
        border-color: rgba(13, 148, 136, 0.25);
    }
</style>
@endsection

@section('content')

@include('admin.sidebar')

<div class="main-content-wrapper">
    <div class="admin-page-container">
        
        <!-- HEADER -->
        <div class="admin-module-header">
            <div class="container-fluid px-3 px-md-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="badge" style="background: rgba(168, 85, 247, 0.2); color: #c084fc; border: 1px solid rgba(168, 85, 247, 0.35); font-weight: 800; padding: 0.35rem 0.75rem; border-radius: 2rem;">
                                Audit Event #{{ $auditLog->id }}
                            </span>
                            <span style="color: #94a3b8; font-size: 0.85rem;">• {{ $auditLog->created_at->format('M d, Y • h:i:s A') }}</span>
                        </div>
                        <h1 style="font-size: clamp(1.5rem, 2.2vw, 2rem); font-weight: 900; margin: 0;">
                            {{ $auditLog->getActionLabel() }}
                        </h1>
                        <p style="color: #94a3b8; font-size: 0.95rem; margin: 0.35rem 0 0;">
                            Actor: <strong>{{ $auditLog->user?->name ?? 'System Process' }}</strong> ({{ $auditLog->user?->email }})
                        </p>
                    </div>

                    <a href="{{ route('admin.audit-logs.index') }}" class="btn btn-outline-light d-inline-flex align-items-center gap-2" style="border-radius: 0.75rem; font-weight: 700; border-color: rgba(255,255,255,0.2);">
                        <i class="fas fa-arrow-left"></i>
                        <span>Back to Audit Trail</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- MAIN CONTENT -->
        <div class="container-fluid px-3 px-md-4 mt-4">
            <div class="row g-4">
                
                <div class="col-lg-8">
                    <!-- Event Description -->
                    <div class="admin-card p-4 mb-4">
                        <h5 style="font-weight: 800; color: #0f172a; margin-bottom: 1rem; font-family: 'Outfit', sans-serif;">
                            <i class="fas fa-align-left text-emerald me-2"></i>Event Description
                        </h5>
                        <div class="p-3 bg-light rounded-3" style="font-size: 0.95rem; line-height: 1.6; color: #334155;">
                            {{ $auditLog->description }}
                        </div>
                    </div>

                    <!-- Changes Diff Inspector -->
                    @if($auditLog->old_values || $auditLog->new_values)
                        <div class="admin-card p-4">
                            <h5 style="font-weight: 800; color: #0f172a; margin-bottom: 1.25rem; font-family: 'Outfit', sans-serif;">
                                <i class="fas fa-exchange-alt text-info me-2"></i>State Changes Inspector
                            </h5>
                            <div class="row g-3">
                                @if($auditLog->old_values)
                                    <div class="col-md-6">
                                        <label class="text-danger font-weight-bold text-uppercase" style="font-size: 0.75rem;">
                                            <i class="fas fa-minus-circle me-1"></i>Previous State
                                        </label>
                                        <pre class="p-3 rounded-3 mt-1" style="background: rgba(239, 68, 68, 0.06); border: 1px solid rgba(239, 68, 68, 0.2); font-size: 0.82rem; color: #991b1b; white-space: pre-wrap;">{{ json_encode($auditLog->old_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                                    </div>
                                @endif
                                @if($auditLog->new_values)
                                    <div class="col-md-6">
                                        <label class="text-success font-weight-bold text-uppercase" style="font-size: 0.75rem;">
                                            <i class="fas fa-plus-circle me-1"></i>Updated State
                                        </label>
                                        <pre class="p-3 rounded-3 mt-1" style="background: rgba(16, 185, 129, 0.06); border: 1px solid rgba(16, 185, 129, 0.2); font-size: 0.82rem; color: #065f46; white-space: pre-wrap;">{{ json_encode($auditLog->new_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Right: Metadata & Client Information -->
                <div class="col-lg-4">
                    <div class="admin-card p-4 mb-4">
                        <h6 style="font-weight: 800; color: #0f172a; margin-bottom: 1.25rem; font-family: 'Outfit', sans-serif;">
                            <i class="fas fa-network-wired text-purple me-2"></i>Network Context
                        </h6>
                        <div class="mb-3">
                            <label class="text-muted font-weight-bold text-uppercase" style="font-size: 0.72rem;">IP ADDRESS</label>
                            <div class="p-2 bg-light rounded font-monospace" style="font-size: 0.85rem;">
                                {{ $auditLog->ip_address ?? '127.0.0.1' }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="text-muted font-weight-bold text-uppercase" style="font-size: 0.72rem;">USER AGENT</label>
                            <div class="p-2 bg-light rounded" style="font-size: 0.8rem; word-break: break-all; color: #475569;">
                                {{ $auditLog->user_agent ?? 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)' }}
                            </div>
                        </div>
                        @if($auditLog->model_type)
                            <div>
                                <label class="text-muted font-weight-bold text-uppercase" style="font-size: 0.72rem;">TARGET OBJECT</label>
                                <div class="p-2 bg-light rounded" style="font-size: 0.85rem;">
                                    {{ $auditLog->getModelLabel() }} #{{ $auditLog->model_id }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
