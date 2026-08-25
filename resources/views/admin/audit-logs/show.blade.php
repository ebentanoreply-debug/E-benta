@extends('layouts.app')

@section('content')
<!-- Include Sidebar -->
@include('admin.sidebar')

<div class="main-content-wrapper" style="margin-left: 260px; overflow-x: hidden; overflow-y: auto; min-height: 100vh; transition: margin-left 0.2s ease, width 0.2s ease; width: calc(100% - 260px); box-sizing: border-box;">
    <div class="container-fluid" style="padding: 2rem;">
    <!-- Back Link -->
    <div class="row mb-4">
        <div class="col-12">
            <a href="{{ route('admin.audit-logs.index') }}" style="color: #0d9488; text-decoration: none; font-weight: 700; font-size: 0.95rem; transition: all 0.3s ease;" onmouseover="this.style.color='#06b6d4';" onmouseout="this.style.color='#0d9488';">
                <i class="fas fa-arrow-left me-2"></i>Back to Audit Logs
            </a>
        </div>
    </div>

    <!-- Main Card -->
    <div class="row">
        <div class="col-12">
            <div style="background: linear-gradient(135deg, #ffffff 0%, #f0f7ff 100%); border: 1px solid rgba(13, 148, 136, 0.15); border-radius: 1.2rem; overflow: hidden; box-shadow: 0 8px 25px rgba(13, 148, 136, 0.08);">
                <!-- Header Bar -->
                <div style="background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%); padding: 2.5rem; color: white;">
                    <h1 style="margin: 0 0 0.5rem 0; font-size: 2rem; font-weight: 800;">
                        <i class="fas fa-history me-2"></i>{{ $auditLog->getActionLabel() }}
                    </h1>
                    <p style="margin: 0; color: rgba(255, 255, 255, 0.9); font-weight: 500;">
                        {{ $auditLog->created_at->format('F d, Y \a\t H:i:s') }}
                    </p>
                </div>

                <!-- Content -->
                <div style="padding: 2.5rem;">
                    <!-- User Info -->
                    <div style="margin-bottom: 2.5rem; padding-bottom: 2rem; border-bottom: 2px solid rgba(13, 148, 136, 0.1);">
                        <h3 style="color: #1e293b; margin-top: 0; font-weight: 800; font-size: 1.15rem; margin-bottom: 1.5rem;">
                            <i class="fas fa-user me-2" style="color: #0d9488;"></i>User Information
                        </h3>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label style="display: block; color: #64748b; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.75rem;">User Name</label>
                                <p style="margin: 0; color: #1e293b; font-size: 1.05rem; font-weight: 700;">{{ $auditLog->user->name }}</p>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label style="display: block; color: #64748b; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.75rem;">Email Address</label>
                                <p style="margin: 0; color: #1e293b; font-size: 1.05rem;">{{ $auditLog->user->email }}</p>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label style="display: block; color: #64748b; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.75rem;">User ID</label>
                                <p style="margin: 0; color: #1e293b; font-size: 1.05rem; font-family: monospace; background: rgba(13, 148, 136, 0.08); padding: 0.6rem 1rem; border-radius: 0.6rem; display: inline-block;">{{ $auditLog->user_id }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Action Details -->
                    <div style="margin-bottom: 2.5rem; padding-bottom: 2rem; border-bottom: 2px solid rgba(13, 148, 136, 0.1);">
                        <h3 style="color: #1e293b; margin-top: 0; font-weight: 800; font-size: 1.15rem; margin-bottom: 1.5rem;">
                            <i class="fas fa-cogs me-2" style="color: #0d9488;"></i>Action Details
                        </h3>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label style="display: block; color: #64748b; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.75rem;">Action Type</label>
                                <span style="background: linear-gradient(135deg, rgba(13, 148, 136, 0.15) 0%, rgba(6, 182, 212, 0.1) 100%); color: #0d9488; padding: 0.6rem 1.2rem; border-radius: 0.6rem; display: inline-block; font-weight: 700; border: 1px solid rgba(13, 148, 136, 0.2);">
                                    {{ $auditLog->getActionLabel() }}
                                </span>
                            </div>
                            @if($auditLog->model_type)
                                <div class="col-md-4 mb-3">
                                    <label style="display: block; color: #64748b; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.75rem;">Model Type</label>
                                    <p style="margin: 0; color: #1e293b; font-size: 1.05rem; font-weight: 700;">{{ $auditLog->getModelLabel() }}</p>
                                </div>
                            @endif
                            @if($auditLog->model_id)
                                <div class="col-md-4 mb-3">
                                    <label style="display: block; color: #64748b; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.75rem;">Model ID</label>
                                    <p style="margin: 0; color: #1e293b; font-size: 1.05rem; font-family: monospace; background: rgba(13, 148, 136, 0.08); padding: 0.6rem 1rem; border-radius: 0.6rem; display: inline-block;">{{ $auditLog->model_id }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Description -->
                    <div style="margin-bottom: 2.5rem; padding: 1.5rem; background: linear-gradient(135deg, rgba(13, 148, 136, 0.08) 0%, rgba(6, 182, 212, 0.05) 100%); border-radius: 0.8rem; border-left: 4px solid #0d9488;">
                        <label style="display: block; color: #64748b; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.75rem;">
                            <i class="fas fa-align-left me-2" style="color: #0d9488;"></i>Description
                        </label>
                        <p style="margin: 0; color: #1e293b; font-size: 1rem; line-height: 1.6;">{{ $auditLog->description }}</p>
                    </div>

                    <!-- Changes -->
                    @if($auditLog->old_values || $auditLog->new_values)
                        <div style="margin-bottom: 2.5rem; padding-bottom: 2rem; border-bottom: 2px solid rgba(13, 148, 136, 0.1);">
                            <h3 style="color: #1e293b; margin-top: 0; font-weight: 800; font-size: 1.15rem; margin-bottom: 1.5rem;">
                                <i class="fas fa-exchange-alt me-2" style="color: #0d9488;"></i>Changes Made
                            </h3>
                            <div class="row">
                                @if($auditLog->old_values)
                                    <div class="col-md-6 mb-3">
                                        <div style="padding: 1.5rem; background: linear-gradient(135deg, rgba(239, 68, 68, 0.08) 0%, rgba(239, 68, 68, 0.04) 100%); border-radius: 0.8rem; border-left: 4px solid #ef4444;">
                                            <h4 style="margin-top: 0; color: #dc2626; font-size: 0.95rem; font-weight: 700; margin-bottom: 1rem;">
                                                <i class="fas fa-minus-circle me-2"></i>Before
                                            </h4>
                                            <pre style="margin: 0; color: #1e293b; font-size: 0.85rem; white-space: pre-wrap; word-wrap: break-word; font-family: 'Courier New', monospace; line-height: 1.5;">{{ json_encode($auditLog->old_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                                        </div>
                                    </div>
                                @endif
                                @if($auditLog->new_values)
                                    <div class="col-md-6 mb-3">
                                        <div style="padding: 1.5rem; background: linear-gradient(135deg, rgba(34, 197, 94, 0.08) 0%, rgba(34, 197, 94, 0.04) 100%); border-radius: 0.8rem; border-left: 4px solid #22c55e;">
                                            <h4 style="margin-top: 0; color: #16a34a; font-size: 0.95rem; font-weight: 700; margin-bottom: 1rem;">
                                                <i class="fas fa-plus-circle me-2"></i>After
                                            </h4>
                                            <pre style="margin: 0; color: #1e293b; font-size: 0.85rem; white-space: pre-wrap; word-wrap: break-word; font-family: 'Courier New', monospace; line-height: 1.5;">{{ json_encode($auditLog->new_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Request Info -->
                    <div style="margin-bottom: 2.5rem; padding-bottom: 2rem; border-bottom: 2px solid rgba(13, 148, 136, 0.1);">
                        <h3 style="color: #1e293b; margin-top: 0; font-weight: 800; font-size: 1.15rem; margin-bottom: 1.5rem;">
                            <i class="fas fa-server me-2" style="color: #0d9488;"></i>Request Information
                        </h3>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label style="display: block; color: #64748b; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.75rem;">IP Address</label>
                                <p style="margin: 0; color: #1e293b; font-size: 1rem; font-family: monospace; background: rgba(13, 148, 136, 0.08); padding: 0.6rem 1rem; border-radius: 0.6rem; display: inline-block;">{{ $auditLog->ip_address ?? 'Unknown' }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <label style="display: block; color: #64748b; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.75rem;">User Agent</label>
                                <p style="margin: 0; color: #1e293b; font-size: 0.9rem; word-break: break-all; line-height: 1.6;">{{ $auditLog->user_agent ?? 'Unknown' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Timestamp -->
                    <div>
                        <label style="display: block; color: #64748b; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.75rem;">
                            <i class="fas fa-clock me-2" style="color: #0d9488;"></i>Timestamp
                        </label>
                        <p style="margin: 0; color: #1e293b; font-size: 1rem;">
                            <strong>{{ $auditLog->created_at->format('F d, Y \a\t H:i:s') }}</strong>
                            <small style="color: #64748b; display: block; margin-top: 0.5rem;">{{ $auditLog->created_at->diffForHumans() }}</small>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

@endsection
