{{-- Notification polling script (shared across buyer & seller layouts) --}}
@auth
<script>
    document.addEventListener('DOMContentLoaded', function() {
        loadRecentNotifications();
        setInterval(loadRecentNotifications, 15000);
    });

    function loadRecentNotifications() {
        fetch('{{ route("notifications.recent") }}')
            .then(response => response.json())
            .then(data => { updateNotificationBell(data); })
            .catch(error => console.error('Error loading notifications:', error));
    }

    function updateNotificationBell(data) {
        const badge = document.getElementById('notification-badge');
        const container = document.getElementById('notifications-menu-container');

        const unreadCount = data.filter(n => !Boolean(n.is_read)).length;

        if (badge) {
            badge.textContent = unreadCount;
            badge.style.display = unreadCount > 0 ? 'inline-flex' : 'none';
        }

        if (!container) return;

        const notificationIcons = {
            'new_buyer_registration': 'fa-user-plus',
            'new_seller_registration': 'fa-store',
            'account_approved': 'fa-check-circle',
            'account_rejected': 'fa-times-circle',
            'offer_received': 'fa-handshake',
            'offer_accepted': 'fa-smile',
            'offer_rejected': 'fa-frown',
            'listing_created': 'fa-clipboard-list',
            'seller_registration_success': 'fa-star',
        };
        const notificationColors = {
            'new_buyer_registration': { icon: '#3498db', bg: 'rgba(52,152,219,0.1)' },
            'new_seller_registration': { icon: '#27ae60', bg: 'rgba(39,174,96,0.1)' },
            'account_approved':        { icon: '#2ecc71', bg: 'rgba(46,204,113,0.1)' },
            'account_rejected':        { icon: '#e74c3c', bg: 'rgba(231,76,60,0.1)' },
            'offer_received':          { icon: '#f39c12', bg: 'rgba(243,156,18,0.1)' },
            'offer_accepted':          { icon: '#2ecc71', bg: 'rgba(46,204,113,0.1)' },
            'offer_rejected':          { icon: '#e74c3c', bg: 'rgba(231,76,60,0.1)' },
            'listing_created':         { icon: '#9b59b6', bg: 'rgba(155,89,182,0.1)' },
            'seller_registration_success': { icon: '#f39c12', bg: 'rgba(243,156,18,0.1)' },
        };

        if (data.length > 0) {
            let html = '<li><div style="padding: 0.5rem 0;">';
            data.forEach(n => {
                const icon   = notificationIcons[n.type] || 'fa-bell';
                const colors = notificationColors[n.type] || { icon: '#3498db', bg: 'rgba(52,152,219,0.1)' };
                const readClass = n.is_read ? 'text-muted' : 'fw-bold';
                const readBg = n.is_read ? '' : `style="background-color:${colors.bg};border-left:3px solid ${colors.icon};"`;
                const titleColor = !n.is_read ? `color:${colors.icon};font-weight:700;` : '';
                const timeAgo = new Date(n.created_at).toLocaleString('en-US', { month:'short', day:'numeric', hour:'2-digit', minute:'2-digit' });
                const url = n.target_url || `/notifications/${n.id}/open`;
                html += `
                    <a class="dropdown-item ${readClass}" href="${url}" ${readBg} style="padding:0.75rem 1rem;margin:0.25rem 0.5rem;border-radius:0.5rem;transition:all 0.2s;display:flex;gap:0.75rem;align-items:flex-start;">
                        <div style="background:${colors.bg};padding:0.5rem;border-radius:0.5rem;flex-shrink:0;display:flex;align-items:center;justify-content:center;width:32px;height:32px;">
                            <i class="fas ${icon}" style="color:${colors.icon};font-size:0.9rem;"></i>
                        </div>
                        <div style="flex:1;min-width:0;">
                            <div style="font-size:0.85rem;${titleColor}">${n.title}</div>
                            <small style="color:#a4b8b5;display:block;white-space:nowrap;text-overflow:ellipsis;overflow:hidden;">${n.message.substring(0,50)}...</small>
                            <small style="color:#7f9e9a;display:block;margin-top:0.25rem;font-size:0.75rem;"><i class="fas fa-clock" style="margin-right:0.25rem;"></i>${timeAgo}</small>
                        </div>
                    </a>`;
            });
            html += '</div></li>';
            container.innerHTML = html;
        } else {
            container.innerHTML = '<li><a class="dropdown-item text-muted" href="{{ route("notifications.index") }}" style="text-align:center;padding:1rem;"><i class="fas fa-inbox me-2"></i>No notifications</a></li>';
        }
    }

    window.refreshNotificationBell = function() { loadRecentNotifications(); }
</script>
@endauth
