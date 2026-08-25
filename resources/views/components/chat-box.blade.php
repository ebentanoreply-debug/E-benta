@php
    $user = auth()->user();
    $isParticipant = ($user->id === $offer->buyer_id || $user->id === $offer->listing->user_id);
    $otherParty = ($user->id === $offer->buyer_id) ? $offer->listing->seller : $offer->buyer;
    $isChatActive = $offer->isChatActive();
    $isChatLocked = $offer->isChatLocked();
@endphp

@if($isParticipant || $user->isAdmin())
<div class="chat-card" id="offer-chat-container">
    <!-- Chat Header -->
    <div class="chat-header">
        <div class="chat-header-info">
            <div class="chat-avatar">
                {{ substr($otherParty->name ?? 'User', 0, 1) }}
            </div>
            <div>
                <h5 class="chat-header-name">
                    {{ $otherParty->name ?? 'User' }}
                    <small class="chat-role-badge">
                        {{ ($otherParty->id === $offer->listing->user_id) ? 'Seller' : 'Buyer' }}
                    </small>
                </h5>
                <p class="chat-status-text">
                    @if($isChatActive)
                        <span class="chat-online-dot"></span> Active Conversation
                    @elseif($isChatLocked)
                        <span class="text-muted"><i class="fas fa-lock me-1"></i> Transaction Completed (Archived)</span>
                    @else
                        <span class="text-warning"><i class="fas fa-clock me-1"></i> Awaiting Offer Acceptance</span>
                    @endif
                </p>
            </div>
        </div>

        @if($isChatActive)
            <span class="badge bg-teal-soft">
                <i class="fas fa-comments me-1"></i> Live Chat
            </span>
        @endif
    </div>

    <!-- Messages Body -->
    <div class="chat-body" id="chat-messages-box">
        <div id="chat-messages-list">
            <!-- Messages dynamically loaded or looped here -->
            @forelse($offer->messages as $msg)
                @php $isMe = ($msg->sender_id === $user->id); @endphp
                <div class="chat-message-row {{ $isMe ? 'me' : 'them' }}" data-message-id="{{ $msg->id }}">
                    @if(!$isMe)
                        <div class="msg-avatar">{{ substr($msg->sender->name ?? 'U', 0, 1) }}</div>
                    @endif
                    <div class="msg-bubble-wrap">
                        <div class="msg-bubble {{ $isMe ? 'bubble-me' : 'bubble-them' }}">
                            {{ $msg->message }}
                        </div>
                        <span class="msg-time">{{ $msg->created_at->format('h:i A') }}</span>
                    </div>
                </div>
            @empty
                <div class="chat-empty" id="chat-empty-notice">
                    <i class="fas fa-comments chat-empty-icon"></i>
                    <p>No messages yet. Say hello to coordinate the transaction!</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Chat Footer -->
    <div class="chat-footer">
        @if($isChatActive)
            <form id="chat-send-form" class="chat-input-form" onsubmit="sendChatMessage(event)">
                @csrf
                <textarea 
                    id="chat-input-text" 
                    class="chat-textarea" 
                    placeholder="Type your message here... (Press Enter to send)" 
                    rows="1" 
                    required 
                    maxlength="2000"
                    onkeydown="handleChatKeyDown(event)"></textarea>
                <button type="submit" id="chat-send-btn" class="chat-send-btn" title="Send Message">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </form>
        @elseif($isChatLocked)
            <div class="chat-locked-notice">
                <i class="fas fa-lock"></i>
                <span>This transaction is finalized. Messaging is archived and locked.</span>
            </div>
        @else
            <div class="chat-locked-notice">
                <i class="fas fa-hourglass-half"></i>
                <span>Messaging will unlock as soon as the seller accepts this offer.</span>
            </div>
        @endif
    </div>
</div>

<style>
    .chat-card {
        background: linear-gradient(135deg, rgba(30, 41, 59, 0.95) 0%, rgba(15, 23, 42, 0.98) 100%);
        border: 1px solid rgba(13, 148, 136, 0.3);
        border-radius: 1.25rem;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
        display: flex;
        flex-direction: column;
        height: 520px;
        overflow: hidden;
        margin-top: 2rem;
    }

    .chat-header {
        padding: 1rem 1.5rem;
        background: rgba(15, 23, 42, 0.7);
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .chat-header-info {
        display: flex;
        align-items: center;
        gap: 0.85rem;
    }

    .chat-avatar {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%);
        color: #ffffff;
        font-weight: 800;
        font-size: 1.1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 12px rgba(13, 148, 136, 0.3);
    }

    .chat-header-name {
        margin: 0;
        color: #ffffff;
        font-weight: 700;
        font-size: 1.05rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .chat-role-badge {
        background: rgba(13, 148, 136, 0.2);
        color: #2dd4bf;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        padding: 0.2rem 0.5rem;
        border-radius: 0.4rem;
        border: 1px solid rgba(13, 148, 136, 0.4);
    }

    .chat-status-text {
        margin: 0.2rem 0 0 0;
        font-size: 0.82rem;
        color: #94a3b8;
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }

    .chat-online-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #10b981;
        box-shadow: 0 0 8px #10b981;
    }

    .bg-teal-soft {
        background: rgba(13, 148, 136, 0.15);
        color: #2dd4bf;
        border: 1px solid rgba(13, 148, 136, 0.3);
        padding: 0.4rem 0.75rem;
        border-radius: 50px;
        font-size: 0.8rem;
    }

    .chat-body {
        flex: 1;
        overflow-y: auto;
        padding: 1.5rem;
        background: rgba(15, 23, 42, 0.4);
    }

    .chat-message-row {
        display: flex;
        gap: 0.75rem;
        margin-bottom: 1.25rem;
        align-items: flex-end;
    }

    .chat-message-row.me {
        justify-content: flex-end;
    }

    .chat-message-row.them {
        justify-content: flex-start;
    }

    .msg-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.1);
        color: #cbd5e1;
        font-weight: 700;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .msg-bubble-wrap {
        max-width: 75%;
        display: flex;
        flex-direction: column;
    }

    .chat-message-row.me .msg-bubble-wrap {
        align-items: flex-end;
    }

    .chat-message-row.them .msg-bubble-wrap {
        align-items: flex-start;
    }

    .msg-bubble {
        padding: 0.75rem 1rem;
        border-radius: 1rem;
        font-size: 0.95rem;
        line-height: 1.5;
        word-break: break-word;
    }

    .bubble-me {
        background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%);
        color: #ffffff;
        border-bottom-right-radius: 0.2rem;
        box-shadow: 0 4px 15px rgba(13, 148, 136, 0.3);
    }

    .bubble-them {
        background: #334155;
        color: #f8fafc;
        border-bottom-left-radius: 0.2rem;
        border: 1px solid rgba(255, 255, 255, 0.08);
    }

    .msg-time {
        font-size: 0.72rem;
        color: #64748b;
        margin-top: 0.25rem;
        padding: 0 0.25rem;
    }

    .chat-empty {
        text-align: center;
        padding: 3rem 1rem;
        color: #64748b;
    }

    .chat-empty-icon {
        font-size: 2.5rem;
        margin-bottom: 0.75rem;
        color: rgba(13, 148, 136, 0.3);
    }

    .chat-footer {
        padding: 1rem 1.25rem;
        background: rgba(15, 23, 42, 0.85);
        border-top: 1px solid rgba(255, 255, 255, 0.08);
    }

    .chat-input-form {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .chat-textarea {
        flex: 1;
        background: rgba(30, 41, 59, 0.9);
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 0.75rem;
        color: #ffffff;
        padding: 0.65rem 1rem;
        font-size: 0.95rem;
        resize: none;
        outline: none;
        transition: border-color 0.2s ease;
    }

    .chat-textarea:focus {
        border-color: #0d9488;
        box-shadow: 0 0 0 2px rgba(13, 148, 136, 0.25);
    }

    .chat-send-btn {
        width: 44px;
        height: 44px;
        border-radius: 0.75rem;
        background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%);
        color: #ffffff;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        cursor: pointer;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        box-shadow: 0 4px 12px rgba(13, 148, 136, 0.3);
    }

    .chat-send-btn:hover {
        transform: scale(1.05);
        box-shadow: 0 6px 18px rgba(13, 148, 136, 0.45);
    }

    .chat-locked-notice {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.6rem;
        padding: 0.75rem;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 0.75rem;
        color: #94a3b8;
        font-size: 0.9rem;
        font-weight: 500;
    }
</style>

<script>
    const CHAT_OFFER_ID = {{ $offer->id }};
    const CURRENT_USER_ID = {{ $user->id }};
    let lastMessageId = {{ $offer->messages->last()?->id ?? 0 }};
    let isChatActiveState = {{ $isChatActive ? 'true' : 'false' }};

    function scrollChatToBottom() {
        const box = document.getElementById('chat-messages-box');
        if (box) {
            box.scrollTop = box.scrollHeight;
        }
    }

    function handleChatKeyDown(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            sendChatMessage(e);
        }
    }

    function sendChatMessage(e) {
        if (e) e.preventDefault();
        const textarea = document.getElementById('chat-input-text');
        if (!textarea) return;

        const message = textarea.value.trim();
        if (!message) return;

        const sendBtn = document.getElementById('chat-send-btn');
        if (sendBtn) sendBtn.disabled = true;

        fetch(`/offers/${CHAT_OFFER_ID}/messages`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ message: message })
        })
        .then(res => res.json())
        .then(data => {
            if (sendBtn) sendBtn.disabled = false;
            if (data.success && data.message) {
                textarea.value = '';
                appendMessageToUI(data.message);
                lastMessageId = Math.max(lastMessageId, data.message.id);
            } else if (data.error) {
                alert(data.error);
            }
        })
        .catch(err => {
            if (sendBtn) sendBtn.disabled = false;
            console.error('Error sending message:', err);
        });
    }

    function appendMessageToUI(msg) {
        const list = document.getElementById('chat-messages-list');
        const emptyNotice = document.getElementById('chat-empty-notice');
        if (emptyNotice) emptyNotice.remove();

        // Check if message already rendered
        if (document.querySelector(`[data-message-id="${msg.id}"]`)) return;

        const isMe = msg.is_me;
        const row = document.createElement('div');
        row.className = `chat-message-row ${isMe ? 'me' : 'them'}`;
        row.setAttribute('data-message-id', msg.id);

        const avatarInitial = (msg.sender_name || 'U').charAt(0);
        const avatarHtml = !isMe ? `<div class="msg-avatar">${avatarInitial}</div>` : '';

        row.innerHTML = `
            ${avatarHtml}
            <div class="msg-bubble-wrap">
                <div class="msg-bubble ${isMe ? 'bubble-me' : 'bubble-them'}">
                    ${escapeHtml(msg.message)}
                </div>
                <span class="msg-time">${msg.created_at || 'Just now'}</span>
            </div>
        `;

        list.appendChild(row);
        scrollChatToBottom();
    }

    function escapeHtml(str) {
        const div = document.createElement('div');
        div.textContent = str;
        return div.innerHTML;
    }

    function pollChatMessages() {
        if (!isChatActiveState) return;

        fetch(`/offers/${CHAT_OFFER_ID}/messages?after_id=${lastMessageId}`, {
            headers: { 'Accept': 'application/json' }
        })
        .then(res => res.json())
        .then(data => {
            if (data.messages && data.messages.length > 0) {
                data.messages.forEach(msg => {
                    appendMessageToUI(msg);
                    lastMessageId = Math.max(lastMessageId, msg.id);
                });
            }
        })
        .catch(err => console.error('Poll error:', err));
    }

    // Scroll to bottom on initial load & start polling
    document.addEventListener('DOMContentLoaded', function() {
        scrollChatToBottom();
        if (isChatActiveState) {
            setInterval(pollChatMessages, 3500);
        }
    });
</script>
@endif
