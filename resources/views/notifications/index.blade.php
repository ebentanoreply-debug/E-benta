@extends('layouts.app')

@section('title', 'Notifications - E-Benta')

@section('content')
<div class="main-content-wrapper" style="margin-left: 0; overflow-x: hidden; min-height: 100vh;">
<div class="container-fluid" style="padding: 2rem;">
    <!-- Header -->
    <div style="background: linear-gradient(135deg, rgba(155, 89, 182, 0.15) 0%, rgba(155, 89, 182, 0.05) 100%); border-left: 4px solid #9b59b6; padding: 2rem; border-radius: 1rem; margin-bottom: 2.5rem; animation: slideInDown 0.4s ease;">
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <div style="background: linear-gradient(135deg, rgba(155, 89, 182, 0.2), rgba(155, 89, 182, 0.1)); padding: 0.75rem 1rem; border-radius: 0.8rem; border: 1px solid rgba(155, 89, 182, 0.3);">
                    <i class="fas fa-bell" style="color: #9b59b6; font-size: 1.8rem;"></i>
                </div>
                <div>
                    <h1 style="color: var(--text-light); font-weight: 800; margin: 0; font-size: 2.2rem; letter-spacing: -0.5px;">
                        Notifications
                    </h1>
                    <p style="color: #a4b8b5; margin: 0; font-size: 1rem; font-weight: 500;">
                        Stay updated on your activity and system events
                    </p>
                </div>
            </div>
            @if($notifications->where('is_read', false)->count() > 0)
                <button id="mark-all-btn" type="button" style="background: linear-gradient(135deg, #9b59b6 0%, #8e44ad 100%); color: white; font-weight: 700; padding: 0.6rem 1.5rem; border: none; border-radius: 0.6rem; text-decoration: none; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(155, 89, 182, 0.25); cursor: pointer;" onmouseover="this.style.boxShadow='0 8px 20px rgba(155, 89, 182, 0.35)'; this.style.transform='translateY(-2px)';" onmouseout="this.style.boxShadow='0 4px 12px rgba(155, 89, 182, 0.25)'; this.style.transform='translateY(0)';">
                    <i class="fas fa-check-circle me-2"></i>Mark All as Read
                </button>
            @endif
        </div>
        
        <!-- Stats -->
        @if($notifications->count() > 0)
            <div style="display: flex; gap: 2rem; margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid rgba(155, 89, 182, 0.2);">
                <div>
                    <small style="color: #a4b8b5; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 0.25rem;">Total</small>
                    <strong style="color: #9b59b6; font-size: 1.3rem;">{{ $notifications->count() }}</strong>
                </div>
                <div>
                    <small style="color: #a4b8b5; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 0.25rem;">Unread</small>
                    <strong style="color: #3498db; font-size: 1.3rem;">{{ $notifications->where('is_read', false)->count() }}</strong>
                </div>
            </div>
        @endif
    </div>

    <!-- Notifications List -->
    <div>
        @if($notifications->isEmpty())
            <div style="background: linear-gradient(135deg, rgba(155, 89, 182, 0.12) 0%, rgba(155, 89, 182, 0.05) 100%); border: 1px solid rgba(155, 89, 182, 0.2); padding: 4rem 2rem; border-radius: 1rem; text-align: center; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);">
                <div style="margin-bottom: 1.5rem;">
                    <i class="fas fa-inbox" style="font-size: 3.5rem; color: rgba(155, 89, 182, 0.3);"></i>
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
                <div class="notification-card" style="background: @if($notification->is_read) linear-gradient(135deg, rgba(164, 184, 181, 0.08) 0%, rgba(164, 184, 181, 0.02) 100%) @else linear-gradient(135deg, {{ $bgColor }} 0%, rgba(255,255,255,0.02) 100%) @endif; border: 1px solid @if($notification->is_read) rgba(164, 184, 181, 0.2) @else rgba(52, 152, 219, 0.2) @endif; padding: 1.75rem; border-radius: 1rem; margin-bottom: 1.5rem; transition: all 0.3s ease; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06); display: flex; align-items: flex-start; gap: 1rem;" onmouseover="this.style.boxShadow='0 8px 20px rgba(0, 0, 0, 0.1)'; this.style.transform='translateX(5px)';" onmouseout="this.style.boxShadow='0 2px 10px rgba(0, 0, 0, 0.06)'; this.style.transform='translateX(0)';">
                    <!-- Icon -->
                    <div style="background: {{ $bgColor }}; padding: 0.75rem; border-radius: 0.8rem; border: 1px solid rgba(52, 152, 219, 0.2); flex-shrink: 0;">
                        <i class="fas {{ $icon }}" style="color: {{ $iconColor }}; font-size: 1.3rem;"></i>
                    </div>
                    
                    <!-- Content -->
                    <div style="flex: 1; min-width: 0;">
                        <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.5rem; flex-wrap: wrap;">
                            <h5 style="color: var(--text-light); font-weight: 700; margin: 0; font-size: 1.05rem;">
                                {{ $notification->title }}
                            </h5>
                            @if(!$notification->is_read)
                                <span style="background: linear-gradient(135deg, {{ $iconColor }}, {{ $bgColor }}); color: white; font-size: 0.65rem; font-weight: 800; padding: 0.3rem 0.6rem; border-radius: 0.4rem; text-transform: uppercase; letter-spacing: 0.5px;">
                                    New
                                </span>
                            @endif
                        </div>
                        <p style="color: #a4b8b5; margin: 0.5rem 0 0 0; font-size: 0.95rem; line-height: 1.5;">
                            {{ $notification->message }}
                        </p>
                        <small style="color: #7f9e9a; display: block; margin-top: 0.75rem; font-weight: 600;">
                            <i class="fas fa-clock me-1"></i>{{ $notification->created_at->diffForHumans() }}
                        </small>
                    </div>
                    
                    <!-- Actions -->
                    <div style="display: flex; gap: 0.5rem; flex-shrink: 0;">
                        @if(!$notification->is_read)
                            <button type="button" class="notification-mark-read" data-notification-id="{{ $notification->id }}" title="Mark as read" style="background: linear-gradient(135deg, rgba(52, 152, 219, 0.2), rgba(52, 152, 219, 0.1)); border: 1px solid rgba(52, 152, 219, 0.3); color: #3498db; padding: 0.5rem 0.8rem; border-radius: 0.5rem; cursor: pointer; transition: all 0.2s ease; font-weight: 600;" onmouseover="this.style.background='linear-gradient(135deg, rgba(52, 152, 219, 0.3), rgba(52, 152, 219, 0.2))'; this.style.boxShadow='0 4px 12px rgba(52, 152, 219, 0.15)';" onmouseout="this.style.background='linear-gradient(135deg, rgba(52, 152, 219, 0.2), rgba(52, 152, 219, 0.1))'; this.style.boxShadow='none';">
                                <i class="fas fa-check-circle"></i>
                            </button>
                        @endif
                        <button type="button" class="notification-delete" data-notification-id="{{ $notification->id }}" title="Delete" style="background: linear-gradient(135deg, rgba(231, 76, 60, 0.2), rgba(231, 76, 60, 0.1)); border: 1px solid rgba(231, 76, 60, 0.3); color: #e74c3c; padding: 0.5rem 0.8rem; border-radius: 0.5rem; cursor: pointer; transition: all 0.2s ease; font-weight: 600;" onmouseover="this.style.background='linear-gradient(135deg, rgba(231, 76, 60, 0.3), rgba(231, 76, 60, 0.2))'; this.style.boxShadow='0 4px 12px rgba(231, 76, 60, 0.15)';" onmouseout="this.style.background='linear-gradient(135deg, rgba(231, 76, 60, 0.2), rgba(231, 76, 60, 0.1))'; this.style.boxShadow='none';">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>

<style>
    @media (max-width: 768px) {
        div[style*="display: flex; align-items: flex-start; justify-content: space-between"] {
            flex-direction: column;
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
