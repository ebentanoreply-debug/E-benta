@extends('layouts.app')

@section('title', 'Notifications - E-Benta')

@section('content')
@section('content')
<div class="main-content-wrapper">
    <div class="container-fluid px-3 px-md-4 py-3 py-md-4" style="max-width: 900px; margin: 0 auto;">
        <!-- Header -->
        <div class="notif-header-card">
            <div class="notif-header-main">
                <div class="notif-header-info">
                    <div class="notif-header-icon">
                        <i class="fas fa-bell"></i>
                    </div>
                    <div>
                        <h1 class="notif-title">Notifications</h1>
                        <p class="notif-subtitle">Stay updated on your activity and system events</p>
                    </div>
                </div>
                @if($notifications->where('is_read', false)->count() > 0)
                    <button id="mark-all-btn" type="button" class="btn-mark-all">
                        <i class="fas fa-check-circle me-2"></i>Mark All as Read
                    </button>
                @endif
            </div>
            
            <!-- Stats -->
            @if($notifications->count() > 0)
                <div class="notif-stats-row">
                    <div>
                        <small class="notif-stat-label">Total</small>
                        <strong class="notif-stat-val text-purple">{{ $notifications->count() }}</strong>
                    </div>
                    <div>
                        <small class="notif-stat-label">Unread</small>
                        <strong class="notif-stat-val text-blue">{{ $notifications->where('is_read', false)->count() }}</strong>
                    </div>
                </div>
            @endif
        </div>

        <!-- Notifications List -->
        <div>
            @if($notifications->isEmpty())
                <div class="notif-empty-card">
                    <div style="margin-bottom: 1.5rem;">
                        <i class="fas fa-inbox notif-empty-icon"></i>
                    </div>
                    <h4 style="color: var(--text-light); font-weight: 700; margin-bottom: 0.5rem;">No notifications yet</h4>
                    <p style="color: #a4b8b5; margin: 0;">Check back later for updates on your activity</p>
                </div>
            @else
                @foreach($notifications as $notification)
                    @php
                        $notificationIcons = [
                            'new_buyer_registration' => 'fa-user-plus',
                            'new_seller_registration' => 'fa-store',
                            'account_approved' => 'fa-check-circle',
                            'account_rejected' => 'fa-times-circle',
                            'offer_received' => 'fa-handshake',
                            'offer_accepted' => 'fa-smile',
                            'offer_rejected' => 'fa-frown',
                            'listing_created' => 'fa-clipboard-list',
                            'seller_registration_success' => 'fa-star',
                        ];
                        $notificationColors = [
                            'new_buyer_registration' => ['icon' => '#3498db', 'bg' => 'rgba(52, 152, 219, 0.2)'],
                            'new_seller_registration' => ['icon' => '#27ae60', 'bg' => 'rgba(39, 174, 96, 0.2)'],
                            'account_approved' => ['icon' => '#2ecc71', 'bg' => 'rgba(46, 204, 113, 0.2)'],
                            'account_rejected' => ['icon' => '#e74c3c', 'bg' => 'rgba(231, 76, 60, 0.2)'],
                            'offer_received' => ['icon' => '#f39c12', 'bg' => 'rgba(243, 156, 18, 0.2)'],
                            'offer_accepted' => ['icon' => '#2ecc71', 'bg' => 'rgba(46, 204, 113, 0.2)'],
                            'offer_rejected' => ['icon' => '#e74c3c', 'bg' => 'rgba(231, 76, 60, 0.2)'],
                            'listing_created' => ['icon' => '#9b59b6', 'bg' => 'rgba(155, 89, 182, 0.2)'],
                            'seller_registration_success' => ['icon' => '#f39c12', 'bg' => 'rgba(243, 156, 18, 0.2)'],
                        ];
                        $icon = $notificationIcons[$notification->type] ?? 'fa-bell';
                        $colors = $notificationColors[$notification->type] ?? ['icon' => '#3498db', 'bg' => 'rgba(52, 152, 219, 0.2)'];
                        $bgColor = $colors['bg'];
                        $iconColor = $colors['icon'];
                    @endphp
                    <div class="notification-card @if($notification->is_read) notif-read @else notif-unread @endif" onclick="window.location.href='{{ route('notifications.open', $notification) }}'" style="cursor: pointer;">
                        <!-- Icon -->
                        <div class="notif-icon-box" style="background: {{ $bgColor }}; border-color: rgba(52, 152, 219, 0.2);">
                            <i class="fas {{ $icon }}" style="color: {{ $iconColor }};"></i>
                        </div>
                        
                        <!-- Content -->
                        <div class="notif-content-box">
                            <div class="notif-title-row">
                                <h5 class="notif-item-title">{{ $notification->title }}</h5>
                                @if(!$notification->is_read)
                                    <span class="notif-badge-new" style="background: linear-gradient(135deg, {{ $iconColor }}, {{ $bgColor }});">
                                        New
                                    </span>
                                @endif
                            </div>
                            <p class="notif-item-msg">
                                {{ $notification->message }}
                            </p>
                            
                            <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 0.75rem; flex-wrap: wrap; gap: 0.5rem;">
                                <small class="notif-item-time" style="margin-top: 0;">
                                    <i class="fas fa-clock me-1"></i>{{ $notification->created_at->diffForHumans() }}
                                </small>
                                
                                <span class="notif-action-link" style="color: var(--light-green); font-weight: 700; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 0.35rem;">
                                    @if($notification->type === 'new_message')
                                        <i class="fas fa-comment-dots"></i> Open Chat <i class="fas fa-arrow-right" style="font-size: 0.75rem;"></i>
                                    @elseif(str_starts_with($notification->type, 'offer_'))
                                        <i class="fas fa-handshake"></i> View Offer <i class="fas fa-arrow-right" style="font-size: 0.75rem;"></i>
                                    @elseif($notification->type === 'listing_created')
                                        <i class="fas fa-box-open"></i> View Listing <i class="fas fa-arrow-right" style="font-size: 0.75rem;"></i>
                                    @elseif(in_array($notification->type, ['new_buyer_registration', 'new_seller_registration', 'pending_verification']))
                                        <i class="fas fa-user-check"></i> Review Verification <i class="fas fa-arrow-right" style="font-size: 0.75rem;"></i>
                                    @else
                                        <i class="fas fa-external-link-alt"></i> View Details <i class="fas fa-arrow-right" style="font-size: 0.75rem;"></i>
                                    @endif
                                </span>
                            </div>
                        </div>
                        
                        <!-- Actions -->
                        <div class="notif-actions-box" onclick="event.stopPropagation();">
                            @if(!$notification->is_read)
                                <button type="button" class="notification-mark-read notif-action-btn notif-btn-read" data-notification-id="{{ $notification->id }}" title="Mark as read">
                                    <i class="fas fa-check-circle"></i>
                                </button>
                            @endif
                            <button type="button" class="notification-delete notif-action-btn notif-btn-del" data-notification-id="{{ $notification->id }}" title="Delete">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>

<style>
    .notif-header-card {
        background: linear-gradient(135deg, rgba(155, 89, 182, 0.15) 0%, rgba(155, 89, 182, 0.05) 100%);
        border-left: 4px solid #9b59b6;
        padding: 2rem;
        border-radius: 1rem;
        margin-bottom: 2rem;
        animation: slideInDown 0.4s ease;
    }

    .notif-header-main {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1.5rem;
        flex-wrap: wrap;
    }

    .notif-header-info {
        display: flex;
        align-items: center;
        gap: 1rem;
        flex: 1;
        min-width: 240px;
    }

    .notif-header-icon {
        background: linear-gradient(135deg, rgba(155, 89, 182, 0.2), rgba(155, 89, 182, 0.1));
        padding: 0.75rem 1rem;
        border-radius: 0.8rem;
        border: 1px solid rgba(155, 89, 182, 0.3);
        flex-shrink: 0;
    }

    .notif-header-icon i {
        color: #9b59b6;
        font-size: 1.8rem;
    }

    .notif-title {
        color: var(--text-light);
        font-weight: 800;
        margin: 0;
        font-size: 2rem;
        letter-spacing: -0.5px;
    }

    .notif-subtitle {
        color: #a4b8b5;
        margin: 0;
        font-size: 0.95rem;
        font-weight: 500;
    }

    .btn-mark-all {
        background: linear-gradient(135deg, #9b59b6 0%, #8e44ad 100%);
        color: white;
        font-weight: 700;
        padding: 0.7rem 1.4rem;
        border: none;
        border-radius: 0.6rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(155, 89, 182, 0.25);
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        white-space: nowrap;
    }

    .btn-mark-all:hover {
        box-shadow: 0 8px 20px rgba(155, 89, 182, 0.35);
        transform: translateY(-2px);
    }

    .notif-stats-row {
        display: flex;
        gap: 2rem;
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid rgba(155, 89, 182, 0.2);
    }

    .notif-stat-label {
        color: #a4b8b5;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: block;
        margin-bottom: 0.25rem;
        font-size: 0.8rem;
    }

    .notif-stat-val {
        font-size: 1.3rem;
    }

    .text-purple { color: #9b59b6; }
    .text-blue { color: #3498db; }

    .notif-empty-card {
        background: linear-gradient(135deg, rgba(155, 89, 182, 0.12) 0%, rgba(155, 89, 182, 0.05) 100%);
        border: 1px solid rgba(155, 89, 182, 0.2);
        padding: 4rem 2rem;
        border-radius: 1rem;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    }

    .notif-empty-icon {
        font-size: 3.5rem;
        color: rgba(155, 89, 182, 0.3);
    }

    /* Notification Items */
    .notification-card {
        border-radius: 1rem;
        margin-bottom: 1.25rem;
        transition: all 0.3s ease;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        padding: 1.5rem;
    }

    .notification-card.notif-unread {
        background: linear-gradient(135deg, rgba(52, 152, 219, 0.12) 0%, rgba(255,255,255,0.02) 100%);
        border: 1px solid rgba(52, 152, 219, 0.3);
    }

    .notification-card.notif-read {
        background: linear-gradient(135deg, rgba(164, 184, 181, 0.08) 0%, rgba(164, 184, 181, 0.02) 100%);
        border: 1px solid rgba(164, 184, 181, 0.2);
    }

    .notif-icon-box {
        padding: 0.75rem;
        border-radius: 0.8rem;
        border: 1px solid rgba(52, 152, 219, 0.2);
        flex-shrink: 0;
        font-size: 1.25rem;
    }

    .notif-content-box {
        flex: 1;
        min-width: 0;
    }

    .notif-title-row {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        margin-bottom: 0.35rem;
        flex-wrap: wrap;
    }

    .notif-item-title {
        color: var(--text-light);
        font-weight: 700;
        margin: 0;
        font-size: 1.05rem;
    }

    .notif-badge-new {
        color: white;
        font-size: 0.65rem;
        font-weight: 800;
        padding: 0.25rem 0.5rem;
        border-radius: 0.4rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .notif-item-msg {
        color: #a4b8b5;
        margin: 0.4rem 0 0 0;
        font-size: 0.92rem;
        line-height: 1.5;
        word-break: break-word;
    }

    .notif-item-time {
        color: #7f9e9a;
        display: block;
        margin-top: 0.6rem;
        font-weight: 600;
        font-size: 0.82rem;
    }

    .notif-actions-box {
        display: flex;
        gap: 0.5rem;
        flex-shrink: 0;
    }

    .notif-action-btn {
        padding: 0.55rem 0.85rem;
        border-radius: 0.5rem;
        cursor: pointer;
        transition: all 0.2s ease;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .notif-btn-read {
        background: linear-gradient(135deg, rgba(52, 152, 219, 0.2), rgba(52, 152, 219, 0.1));
        border: 1px solid rgba(52, 152, 219, 0.3);
        color: #3498db;
    }

    .notif-btn-del {
        background: linear-gradient(135deg, rgba(231, 76, 60, 0.2), rgba(231, 76, 60, 0.1));
        border: 1px solid rgba(231, 76, 60, 0.3);
        color: #e74c3c;
    }

    @media (max-width: 768px) {
        .notif-header-card {
            padding: 1.5rem 1rem;
            margin-bottom: 1.5rem;
        }

        .notif-header-main {
            flex-direction: column;
            align-items: stretch;
            gap: 1rem;
        }

        .notif-title {
            font-size: 1.5rem;
        }

        .btn-mark-all {
            width: 100%;
        }

        .notification-card {
            padding: 1.25rem 1rem;
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .notif-actions-box {
            width: 100%;
            justify-content: flex-end;
            margin-top: 0.25rem;
            padding-top: 0.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }
    }
    
    /* Toast Notification Styles */
    .toast-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
    }
    
    .toast {
        background: linear-gradient(135deg, rgba(46, 204, 113, 0.95), rgba(39, 174, 96, 0.95));
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 0.5rem;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        margin-bottom: 10px;
        animation: slideInRight 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        max-width: 350px;
    }
    
    .toast.error {
        background: linear-gradient(135deg, rgba(231, 76, 60, 0.95), rgba(192, 57, 43, 0.95));
    }
    
    .toast i {
        font-size: 1.2rem;
    }
    
    @keyframes slideInRight {
        from {
            transform: translateX(400px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes fadeOut {
        to {
            opacity: 0;
            transform: translateX(400px);
        }
    }
    
    .notification-card {
        transition: all 0.3s ease;
    }
    
    .notification-card.fade-out {
        animation: fadeOut 0.3s ease forwards;
    }
    
    .notification-card.loading {
        opacity: 0.6;
        pointer-events: none;
    }
    
    .spinner {
        display: inline-block;
        width: 14px;
        height: 14px;
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        border-top-color: white;
        animation: spin 0.8s linear infinite;
    }
    
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
</style>

<script>
    // Helper function to safely get CSRF token
    function getCsrfToken() {
        const meta = document.querySelector('meta[name="csrf-token"]');
        if (!meta) {
            console.error('❌ CSRF token meta tag not found!');
            return '';
        }
        return meta.getAttribute('content');
    }
    
    // Toast notification system
    function showToast(message, type = 'success') {
        const container = document.querySelector('.toast-container') || (() => {
            const c = document.createElement('div');
            c.className = 'toast-container';
            document.body.appendChild(c);
            return c;
        })();
        
        const toast = document.createElement('div');
        toast.className = `toast ${type}`;
        toast.innerHTML = `
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
            <span>${message}</span>
        `;
        
        container.appendChild(toast);
        
        setTimeout(() => {
            toast.style.animation = 'fadeOut 0.3s ease forwards';
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }
    
    // Mark as read handler
    document.querySelectorAll('.notification-mark-read').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const notificationId = this.dataset.notificationId;
            const card = this.closest('.notification-card');
            const badge = card.querySelector('span:has(i.fas-check-circle)');
            
            // Remove UI elements immediately (optimistic update)
            if (badge && badge.textContent.includes('New')) {
                badge.remove();
            }
            this.remove();
            
            // Show loading state briefly
            showToast('Marking as read...', 'success');
            
            // Send request in background
            fetch(`/notifications/${notificationId}/mark-as-read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': getCsrfToken(),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) throw new Error('Failed to mark as read');
                return response.json();
            })
            .then(data => {
                // Update unread count in navbar
                updateUnreadCount();
                // Refresh notification bell in navbar immediately
                setTimeout(() => {
                    if (window.refreshNotificationBell) {
                        window.refreshNotificationBell();
                    }
                }, 300);
            })
            .catch(error => {
                console.error('Error:', error);
                // Note: UI already updated, just log error
            });
        });
    });
    
    // Delete handler
    document.querySelectorAll('.notification-delete').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const notificationId = this.dataset.notificationId;
            const card = this.closest('.notification-card');
            
            // Remove card immediately (optimistic update)
            card.remove();
            
            // Show toast
            showToast('Deleting notification...', 'success');
            
            // Send request in background
            fetch(`/notifications/${notificationId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': getCsrfToken(),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) throw new Error('Failed to delete');
                return response.json();
            })
            .then(data => {
                // Update unread count in navbar
                updateUnreadCount();
                // Refresh notification bell in navbar immediately
                setTimeout(() => {
                    if (window.refreshNotificationBell) {
                        window.refreshNotificationBell();
                    }
                }, 300);
            })
            .catch(error => {
                console.error('Error:', error);
                // Note: UI already updated, just log error
            });
        });
    });
    
    // Mark all as read handler
    const markAllBtn = document.getElementById('mark-all-btn');
    if (markAllBtn) {
        markAllBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const btn = this;
            
            console.log('🚀 Mark all as read clicked!');
            
            // Remove UI elements immediately (optimistic update)
            document.querySelectorAll('span:has(i.fas-check-circle)').forEach(badge => {
                if (badge.textContent.includes('New')) {
                    badge.remove();
                }
            });
            
            document.querySelectorAll('.notification-mark-read').forEach(btn => {
                btn.remove();
            });
            
            btn.remove();
            
            // Show toast
            showToast('Marking all as read...', 'success');
            
            console.log('📱 Sending mark-all-as-read request...');
            
            // Send request in background
            fetch('{{ route("notifications.mark-all-as-read") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': getCsrfToken(),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                console.log('📬 Response status:', response.status, response.statusText);
                if (!response.ok) throw new Error('Failed to mark all as read');
                return response.json();
            })
            .then(data => {
                console.log('✅ Mark all as read response:', data);
                console.log('📊 Unread count from API:', data.unread_count);
                console.log('🎯 Calling updateUnreadCount()...');
                // Update unread count in navbar
                updateUnreadCount();
                // Refresh notification bell in navbar immediately
                setTimeout(() => {
                    console.log('🔔 Refreshing notification bell after 300ms delay...');
                    if (window.refreshNotificationBell) {
                        window.refreshNotificationBell();
                    } else {
                        console.warn('⚠️ window.refreshNotificationBell not found!');
                    }
                }, 300);
            })
            .catch(error => {
                console.error('❌ Error marking all as read:', error);
                // Note: UI already updated, just log error
            });
        });
    }
    
    // Update unread count in navbar
    function updateUnreadCount() {
        fetch('/notifications/unread-count')
            .then(response => response.json())
            .then(data => {
                const badge = document.querySelector('#notification-badge');
                if (badge) {
                    if (data.unread_count > 0) {
                        badge.textContent = data.unread_count;
                        badge.style.display = 'inline-flex';
                    } else {
                        badge.style.display = 'none';
                        badge.textContent = '0';
                    }
                }
                console.log('✅ Updated notification badge - Count:', data.unread_count);
            })
            .catch(error => console.error('Error updating unread count:', error));
    }
</script>
</div>
</div>

@endsection
