@extends('layouts.app')

@section('title', 'Messages & Coordination - E-Benta')

@section('styles')
<style>
    .inbox-wrapper {
        min-height: calc(100vh - 60px);
        padding: 1.5rem 1rem 3rem;
        background: #09171f;
    }

    body.dark-mode .inbox-wrapper {
        background: #060e14;
    }

    .inbox-container {
        max-width: 1350px;
        margin: 0 auto;
        background: linear-gradient(135deg, #0f232d 0%, #09171f 100%);
        border: 1px solid rgba(13, 148, 136, 0.25);
        border-radius: 1.25rem;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4);
        display: flex;
        height: calc(100vh - 120px);
        min-height: 600px;
        max-height: 820px;
        overflow: hidden;
    }

    /* Left Column: Conversations List */
    .inbox-sidebar {
        width: 360px;
        border-right: 1px solid rgba(255, 255, 255, 0.08);
        display: flex;
        flex-direction: column;
        background: rgba(15, 23, 42, 0.6);
        flex-shrink: 0;
    }

    .inbox-sidebar-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .inbox-sidebar-header h4 {
        margin: 0;
        color: #ffffff;
        font-weight: 800;
        font-size: 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .inbox-conversations-list {
        flex: 1;
        overflow-y: auto;
        padding: 0.75rem;
        display: flex;
        flex-direction: column;
        gap: 0.4rem;
    }

    .inbox-item {
        display: flex;
        align-items: center;
        gap: 0.85rem;
        padding: 0.85rem 1rem;
        border-radius: 0.85rem;
        text-decoration: none;
        transition: all 0.2s ease;
        border: 1px solid transparent;
        background: transparent;
    }

    .inbox-item:hover {
        background: rgba(255, 255, 255, 0.05);
    }

    .inbox-item.active {
        background: linear-gradient(135deg, rgba(13, 148, 136, 0.2) 0%, rgba(6, 182, 212, 0.1) 100%);
        border-color: rgba(13, 148, 136, 0.35);
    }

    .inbox-item-avatar {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%);
        color: #ffffff;
        font-weight: 800;
        font-size: 1.1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .inbox-item-details {
        flex: 1;
        min-width: 0;
    }

    .inbox-item-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.25rem;
    }

    .inbox-item-name {
        color: #ffffff;
        font-weight: 700;
        font-size: 0.95rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .inbox-item-time {
        font-size: 0.72rem;
        color: #64748b;
        flex-shrink: 0;
    }

    .inbox-item-device {
        color: #2dd4bf;
        font-size: 0.8rem;
        font-weight: 600;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        display: block;
        margin-bottom: 0.2rem;
    }

    .inbox-item-snippet {
        color: #94a3b8;
        font-size: 0.82rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        margin: 0;
    }

    .inbox-badge-locked {
        font-size: 0.7rem;
        color: #94a3b8;
        background: rgba(255, 255, 255, 0.08);
        padding: 0.15rem 0.4rem;
        border-radius: 0.3rem;
    }

    /* Right Column: Chat Box */
    .inbox-chat-pane {
        flex: 1;
        display: flex;
        flex-direction: column;
        min-width: 0;
        background: rgba(15, 23, 42, 0.3);
    }

    .inbox-chat-topbar {
        padding: 1rem 1.5rem;
        background: rgba(15, 23, 42, 0.8);
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
    }

    .inbox-chat-topbar-info {
        display: flex;
        align-items: center;
        gap: 0.85rem;
    }

    .inbox-chat-messages {
        flex: 1;
        overflow-y: auto;
        padding: 1.5rem;
    }

    .inbox-chat-inputbar {
        padding: 1rem 1.25rem;
        background: rgba(15, 23, 42, 0.85);
        border-top: 1px solid rgba(255, 255, 255, 0.08);
    }

    .inbox-empty-state {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: #64748b;
        padding: 2rem;
        text-align: center;
    }

    .inbox-empty-state i {
        font-size: 3.5rem;
        margin-bottom: 1rem;
        color: rgba(13, 148, 136, 0.3);
    }

    @media (max-width: 768px) {
        .inbox-container {
            flex-direction: column;
            height: auto;
            min-height: 580px;
        }

        .inbox-sidebar {
            width: 100%;
            max-height: 240px;
            border-right: none;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }
    }

    /* ── Sidebar item components ─────────────────────── */
    .inbox-item-avatar {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: linear-gradient(135deg, #0d9488, #06b6d4);
        color: #ffffff;
        font-weight: 800;
        font-size: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        overflow: hidden;
    }

    .inbox-item-details {
        flex: 1;
        min-width: 0;
    }

    .inbox-item-top {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        margin-bottom: 0.15rem;
    }

    .inbox-item-name {
        font-weight: 700;
        font-size: 0.9rem;
        color: #e2e8f0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .inbox-item-time {
        font-size: 0.72rem;
        color: #64748b;
        white-space: nowrap;
        margin-left: 0.5rem;
    }

    .inbox-item-device {
        display: block;
        font-size: 0.75rem;
        color: #2dd4bf;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        margin-bottom: 0.15rem;
    }

    .inbox-item-snippet {
        font-size: 0.8rem;
        color: #64748b;
        margin: 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .inbox-badge-locked {
        font-size: 0.65rem;
        padding: 0.15rem 0.5rem;
        background: rgba(239, 68, 68, 0.15);
        color: #fca5a5;
        border-radius: 99px;
        border: 1px solid rgba(239, 68, 68, 0.3);
        white-space: nowrap;
        flex-shrink: 0;
    }

    .chat-role-badge {
        font-size: 0.7rem;
        padding: 0.15rem 0.55rem;
        background: rgba(13, 148, 136, 0.2);
        color: #2dd4bf;
        border-radius: 99px;
        border: 1px solid rgba(13, 148, 136, 0.35);
        margin-left: 0.5rem;
        font-weight: 600;
    }

    /* ── Chat message bubbles ────────────────────────── */
    .chat-message-row {
        display: flex;
        align-items: flex-end;
        gap: 0.6rem;
        margin-bottom: 1rem;
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

    /* ── Chat input bar ──────────────────────────────── */
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
        font-family: inherit;
    }

    .chat-textarea::placeholder { color: #475569; }

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
        flex-shrink: 0;
    }

    .chat-send-btn:hover {
        transform: scale(1.05);
        box-shadow: 0 6px 18px rgba(13, 148, 136, 0.45);
    }

    .chat-send-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none;
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

    /* ── Empty states ────────────────────────────────── */
    .chat-empty {
        text-align: center;
        padding: 3rem 1rem;
        color: #64748b;
    }

    .chat-empty-icon {
        font-size: 2.5rem;
        margin-bottom: 0.75rem;
        display: block;
        color: rgba(13, 148, 136, 0.3);
    }

    /* ── Bootstrap badge soft variant ───────────────── */
    .bg-teal-soft {
        background: rgba(13, 148, 136, 0.15);
        color: #2dd4bf;
        border: 1px solid rgba(13, 148, 136, 0.3);
        font-size: 0.75rem;
        padding: 0.25rem 0.75rem;
        border-radius: 99px;
        font-weight: 600;
    }

    .text-teal { color: #2dd4bf; margin-right: 0.4rem; }
</style>
@endsection


@section('content')

@if(auth()->check() && auth()->user()->isAdmin())
    @include('admin.sidebar')
@elseif(auth()->check() && auth()->user()->isSeller())
    @include('seller.sidebar')
@elseif(auth()->check())
    @include('buyer.sidebar')
@endif

<div class="main-content-wrapper">
    <div class="inbox-wrapper">
        <div class="inbox-container">
            <!-- Left Sidebar: Conversations -->
            <div class="inbox-sidebar">
                <div class="inbox-sidebar-header">
                    <h4><i class="fas fa-comments text-teal"></i> Messages</h4>
                    <span class="badge bg-teal-soft">{{ $offers->count() }} Conversations</span>
                </div>

                <div class="inbox-conversations-list">
                    @forelse($offers as $off)
                        @php
                            $other = (auth()->id() === $off->buyer_id) ? $off->listing->seller : $off->buyer;
                            $isActive = ($activeOffer && $activeOffer->id === $off->id);
                            $lastMsg = $off->messages->first();
                            $locked = $off->isChatLocked();
                        @endphp
                        <a href="{{ route('messages.index', ['offer_id' => $off->id]) }}" class="inbox-item {{ $isActive ? 'active' : '' }}">
                            <div class="inbox-item-avatar">
                                @if($other && $other->avatar_url)
                                    <img src="{{ $other->avatar_url }}" alt="{{ $other->name }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                                @else
                                    {{ substr($other->name ?? 'U', 0, 1) }}
                                @endif
                            </div>
                            <div class="inbox-item-details">
                                <div class="inbox-item-top">
                                    <span class="inbox-item-name">{{ $other->name ?? 'User' }}</span>
                                    @if($lastMsg)
                                        <span class="inbox-item-time">{{ $lastMsg->created_at->diffForHumans(null, true) }}</span>
                                    @endif
                                </div>
                                <span class="inbox-item-device">
                                    <i class="fas fa-mobile-alt me-1"></i>{{ $off->listing->title ?? $off->listing->category }}
                                </span>
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <p class="inbox-item-snippet">
                                        {{ $lastMsg ? $lastMsg->message : 'No messages yet' }}
                                    </p>
                                    @if($locked)
                                        <span class="inbox-badge-locked"><i class="fas fa-lock"></i> Closed</span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @empty
                        <div style="text-align: center; padding: 3rem 1rem; color: #64748b;">
                            <i class="fas fa-inbox" style="font-size: 2rem; margin-bottom: 0.75rem; display: block;"></i>
                            <p style="margin: 0; font-size: 0.9rem;">No accepted offer conversations yet. When an offer is accepted, chat unlocks here!</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Right Pane: Active Chat -->
            <div class="inbox-chat-pane">
                @if($activeOffer)
                    @php
                        $user = auth()->user();
                        $otherParty = ($user->id === $activeOffer->buyer_id) ? $activeOffer->listing->seller : $activeOffer->buyer;
                        $isChatActive = $activeOffer->isChatActive();
                        $isChatLocked = $activeOffer->isChatLocked();
                    @endphp
                    <!-- Chat Top Bar -->
                    <div class="inbox-chat-topbar">
                        <div class="inbox-chat-topbar-info">
                            <div class="inbox-item-avatar">
                                @if($otherParty && $otherParty->avatar_url)
                                    <img src="{{ $otherParty->avatar_url }}" alt="{{ $otherParty->name }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                                @else
                                    {{ substr($otherParty->name ?? 'U', 0, 1) }}
                                @endif
                            </div>
                            <div>
                                <h5 style="color: #ffffff; font-weight: 700; margin: 0; font-size: 1.05rem;">
                                    {{ $otherParty->name ?? 'User' }}
                                    <small class="chat-role-badge">
                                        {{ ($otherParty->id === $activeOffer->listing->user_id) ? 'Seller' : 'Buyer' }}
                                    </small>
                                </h5>
                                <small style="color: #94a3b8; font-size: 0.8rem;">
                                    Item: <strong>{{ $activeOffer->listing->title ?? $activeOffer->listing->category }}</strong> • Offer: <strong style="color: #2dd4bf;">₱{{ number_format($activeOffer->bid_amount, 2) }}</strong>
                                </small>
                            </div>
                        </div>

                        <a href="{{ route('offers.show', $activeOffer) }}" class="btn btn-sm" style="background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(255, 255, 255, 0.15); color: #cbd5e1; border-radius: 0.5rem; font-size: 0.82rem; font-weight: 600;">
                            <i class="fas fa-file-contract me-1"></i> Offer Details
                        </a>
                    </div>

                    <!-- Messages Body -->
                    <div class="inbox-chat-messages" id="inbox-messages-box">
                        <div id="inbox-messages-list">
                            @forelse($activeOffer->messages as $msg)
                                @php $isMe = ($msg->sender_id === $user->id); @endphp
                                <div class="chat-message-row {{ $isMe ? 'me' : 'them' }}" data-message-id="{{ $msg->id }}">
                                    @if(!$isMe)
                                        <div class="msg-avatar">{{ substr($msg->sender->name ?? 'U', 0, 1) }}</div>
                                    @endif
                                    <div class="msg-bubble-wrap">
                                        <div class="msg-bubble {{ $isMe ? 'bubble-me' : 'bubble-them' }}">
                                            {{ $msg->message }}
                                        </div>
                                        <span class="msg-time">{{ $msg->created_at->format('M d, h:i A') }}</span>
                                    </div>
                                </div>
                            @empty
                                <div class="chat-empty" id="inbox-empty-notice">
                                    <i class="fas fa-comments chat-empty-icon"></i>
                                    <p>No messages yet. Send a message to coordinate pickup!</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Input Bar -->
                    <div class="inbox-chat-inputbar">
                        @if($isChatActive)
                            <form id="inbox-send-form" class="chat-input-form" onsubmit="sendInboxMessage(event)">
                                @csrf
                                <textarea 
                                    id="inbox-input-text" 
                                    class="chat-textarea" 
                                    placeholder="Type your message here... (Press Enter to send)" 
                                    rows="1" 
                                    required 
                                    maxlength="2000"
                                    onkeydown="handleInboxKeyDown(event)"></textarea>
                                <button type="submit" id="inbox-send-btn" class="chat-send-btn" title="Send Message">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </form>
                        @elseif($isChatLocked)
                            <div class="chat-locked-notice">
                                <i class="fas fa-lock"></i>
                                <span>This transaction is completed. Messaging is closed and archived.</span>
                            </div>
                        @else
                            <div class="chat-locked-notice">
                                <i class="fas fa-hourglass-half"></i>
                                <span>Messaging will unlock once the seller accepts this offer.</span>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="inbox-empty-state">
                        <i class="fas fa-comments"></i>
                        <h4 style="color: #ffffff; font-weight: 700;">No Conversation Selected</h4>
                        <p>Select an offer on the left or accept an offer to start coordinating.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@if($activeOffer)
<script>
    const ACTIVE_OFFER_ID = {{ $activeOffer->id }};
    let inboxLastId = {{ $activeOffer->messages->last()?->id ?? 0 }};
    let isInboxActive = {{ $activeOffer->isChatActive() ? 'true' : 'false' }};

    function scrollInboxToBottom() {
        const box = document.getElementById('inbox-messages-box');
        if (box) {
            box.scrollTop = box.scrollHeight;
        }
    }

    function handleInboxKeyDown(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            sendInboxMessage(e);
        }
    }

    function sendInboxMessage(e) {
        if (e) e.preventDefault();
        const textarea = document.getElementById('inbox-input-text');
        if (!textarea) return;

        const message = textarea.value.trim();
        if (!message) return;

        const sendBtn = document.getElementById('inbox-send-btn');
        if (sendBtn) sendBtn.disabled = true;

        fetch(`/offers/${ACTIVE_OFFER_ID}/messages`, {
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
                appendInboxMessage(data.message);
                inboxLastId = Math.max(inboxLastId, data.message.id);
            } else if (data.error) {
                alert(data.error);
            }
        })
        .catch(err => {
            if (sendBtn) sendBtn.disabled = false;
            console.error('Send error:', err);
        });
    }

    function appendInboxMessage(msg) {
        const list = document.getElementById('inbox-messages-list');
        const emptyNotice = document.getElementById('inbox-empty-notice');
        if (emptyNotice) emptyNotice.remove();

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
        scrollInboxToBottom();
    }

    function pollInboxMessages() {
        if (!isInboxActive) return;

        fetch(`/offers/${ACTIVE_OFFER_ID}/messages?after_id=${inboxLastId}`, {
            headers: { 'Accept': 'application/json' }
        })
        .then(res => res.json())
        .then(data => {
            if (data.messages && data.messages.length > 0) {
                data.messages.forEach(msg => {
                    appendInboxMessage(msg);
                    inboxLastId = Math.max(inboxLastId, msg.id);
                });
            }
        })
        .catch(err => console.error('Poll error:', err));
    }

    document.addEventListener('DOMContentLoaded', function() {
        scrollInboxToBottom();
        if (isInboxActive) {
            setInterval(pollInboxMessages, 3500);
        }
    });

    function escapeHtml(str) {
        const div = document.createElement('div');
        div.appendChild(document.createTextNode(str));
        return div.innerHTML;
    }
</script>
@endif
@endsection
