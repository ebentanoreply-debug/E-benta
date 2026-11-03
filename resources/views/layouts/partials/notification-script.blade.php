{{-- Notification polling & realtime badge decrement script (shared across all layouts) --}}
@auth
<script>
    document.addEventListener('DOMContentLoaded', function() {
        loadRecentNotifications();
        setInterval(loadRecentNotifications, 15000);
    });

    function loadRecentNotifications() {
        Promise.all([
            fetch('{{ route("notifications.recent") }}').then(r => r.json()).catch(() => []),
            fetch('{{ route("notifications.unread-count") }}').then(r => r.json()).catch(() => null)
        ])
        .then(([data, countData]) => {
            const list = Array.isArray(data) ? data : [];
            const serverCount = (countData && typeof countData.unread_count === 'number')
                ? countData.unread_count
                : list.filter(n => !Boolean(n.is_read)).length;
            updateNotificationBell(list, serverCount);
        })
        .catch(error => console.error('Error loading notifications:', error));
    }

    function updateNotificationBell(data, unreadCount) {
        const badges = document.querySelectorAll('#notification-badge, .notification-badge-el, .commerce-badge');
        const container = document.getElementById('notifications-menu-container');

        if (typeof unreadCount === 'undefined') {
            unreadCount = Array.isArray(data) ? data.filter(n => !Boolean(n.is_read)).length : 0;
        }

        badges.forEach(badge => {
            badge.textContent = unreadCount;
            badge.style.display = unreadCount > 0 ? 'inline-flex' : 'none';
        });

        if (!container) return;

        const notificationIcons = {
            'new_buyer_registration': 'fa-user-plus',
            'new_seller_registration': 'fa-store',
            'account_approved':        'fa-check-circle',
            'account_rejected':        'fa-times-circle',
            'offer_received':          'fa-handshake',
            'offer_accepted':          'fa-smile',
            'offer_rejected':          'fa-frown',
            'listing_created':         'fa-clipboard-list',
            'seller_registration_success': 'fa-star',
            'new_message':             'fa-comment-dots',
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
            'new_message':             { icon: '#0ea5e9', bg: 'rgba(14,165,233,0.1)' },
        };

        if (data.length > 0) {
            let html = '<li><div style="padding: 0.5rem 0;">';
            data.forEach(n => {
                const icon = notificationIcons[n.type] || 'fa-bell';
                const colors = notificationColors[n.type] || { icon: '#3498db', bg: 'rgba(52,152,219,0.1)' };
                const isUnread = !Boolean(n.is_read);
                const readClass = isUnread ? 'fw-bold' : 'text-muted';
                const readBg = isUnread ? `style="background-color:${colors.bg};border-left:3px solid ${colors.icon};"` : '';
                const titleColor = isUnread ? `color:${colors.icon};font-weight:700;` : '';
                const timeAgo = new Date(n.created_at).toLocaleString('en-US', { month:'short', day:'numeric', hour:'2-digit', minute:'2-digit' });
                const openUrl = `/notifications/${n.id}/open`;

                html += `
                    <a class="dropdown-item ${readClass} notif-dropdown-link" 
                       href="${openUrl}" 
                       data-notification-id="${n.id}" 
                       data-is-unread="${isUnread ? '1' : '0'}"
                       onclick="onNotificationItemClick(event, ${n.id}, ${isUnread ? 'true' : 'false'})"
                       ${readBg} 
                       style="padding:0.75rem 1rem;margin:0.25rem 0.5rem;border-radius:0.5rem;transition:all 0.2s;display:flex;gap:0.75rem;align-items:flex-start;">
                        <div style="background:${colors.bg};padding:0.5rem;border-radius:0.5rem;flex-shrink:0;display:flex;align-items:center;justify-content:center;width:32px;height:32px;">
                            <i class="fas ${icon}" style="color:${colors.icon};font-size:0.9rem;"></i>
                        </div>
                        <div style="flex:1;min-width:0;">
                            <div class="notif-item-title-text" style="font-size:0.85rem;${titleColor}">${n.title}</div>
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

    window.decrementNotificationBadges = function() {
        const badges = document.querySelectorAll('#notification-badge, .notification-badge-el, .commerce-badge');
        badges.forEach(badge => {
            const current = parseInt(badge.textContent.trim(), 10) || 0;
            const updated = Math.max(0, current - 1);
            badge.textContent = updated;
            if (updated === 0) {
                badge.style.display = 'none';
            } else {
                badge.style.display = 'inline-flex';
            }
        });
    };

    window.onNotificationItemClick = function(event, notificationId, isUnread) {
        if (!isUnread) return;

        // 1. Instantly decrement all badges on screen
        decrementNotificationBadges();

        // 2. Mark this item visually as read
        const item = event.currentTarget;
        if (item) {
            item.classList.remove('fw-bold');
            item.classList.add('text-muted');
            item.style.backgroundColor = '';
            item.style.borderLeft = '';
            item.dataset.isUnread = '0';
            const title = item.querySelector('.notif-item-title-text');
            if (title) {
                title.style.color = '';
                title.style.fontWeight = 'normal';
            }
        }

        // 3. Send async background request to mark as read immediately
        try {
            const csrfMeta = document.querySelector('meta[name="csrf-token"]');
            const token = csrfMeta ? csrfMeta.getAttribute('content') : '';
            if (token) {
                fetch(`/notifications/${notificationId}/mark-as-read`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    keepalive: true
                }).catch(() => {});
            }
        } catch (e) {}
    };

    window.refreshNotificationBell = function() { loadRecentNotifications(); };
</script>
@endauth
