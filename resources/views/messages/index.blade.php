@extends('layouts.app')

@section('title', 'Messages & Coordination - E-Benta')

@section('styles')
<style>
    .inbox-page-wrapper {
        background: #f8fafc;
        min-height: calc(100vh - 180px);
        padding-bottom: 2.5rem;
    }

    body.dark-mode .inbox-page-wrapper {
        background: #09171f;
    }

    .inbox-breadcrumb-bar {
        background: #ffffff;
        border-bottom: 1px solid #e2e8f0;
        padding: 0.75rem 0;
        margin-bottom: 1.5rem;
    }

    body.dark-mode .inbox-breadcrumb-bar {
        background: #0c1c24;
        border-bottom-color: rgba(13, 148, 136, 0.2);
    }

    .inbox-container {
        max-width: 1400px;
        margin: 0 auto;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 1.25rem;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.05);
        display: flex;
        height: calc(100vh - 230px);
        min-height: 600px;
        max-height: 840px;
        overflow: hidden;
    }

    body.dark-mode .inbox-container {
        background: linear-gradient(135deg, #0f232d 0%, #09171f 100%);
        border-color: rgba(13, 148, 136, 0.25);
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4);
    }

    /* Left Column: Conversations List */
    .inbox-sidebar {
        width: 380px;
        border-right: 1px solid #e2e8f0;
        display: flex;
        flex-direction: column;
        background: #f8fafc;
        flex-shrink: 0;
    }

    body.dark-mode .inbox-sidebar {
        background: rgba(15, 23, 42, 0.6);
        border-right-color: rgba(255, 255, 255, 0.08);
    }

    .inbox-sidebar-header {
        padding: 1.25rem 1.5rem;
        background: #ffffff;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    body.dark-mode .inbox-sidebar-header {
        background: rgba(15, 23, 42, 0.8);
        border-bottom-color: rgba(255, 255, 255, 0.08);
    }

    .inbox-sidebar-header h4 {
        margin: 0;
        color: #0f172a;
        font-weight: 800;
        font-size: 1.2rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    body.dark-mode .inbox-sidebar-header h4 {
        color: #ffffff;
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
        background: #f1f5f9;
    }

    body.dark-mode .inbox-item:hover {
        background: rgba(255, 255, 255, 0.05);
    }

    .inbox-item.active {
        background: #f0fdfa;
        border-color: rgba(13, 148, 136, 0.35);
        box-shadow: 0 2px 10px rgba(13, 148, 136, 0.08);
    }

    body.dark-mode .inbox-item.active {
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
        color: #0f172a;
        font-weight: 700;
        font-size: 0.92rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    body.dark-mode .inbox-item-name {
        color: #e2e8f0;
    }

    .inbox-item-time {
        font-size: 0.72rem;
        color: #64748b;
        white-space: nowrap;
        margin-left: 0.5rem;
    }

    .inbox-item-device {
        display: block;
        font-size: 0.78rem;
        color: #0d9488;
        font-weight: 700;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        margin-bottom: 0.15rem;
    }

    body.dark-mode .inbox-item-device {
        color: #2dd4bf;
    }

    .inbox-item-snippet {
        font-size: 0.8rem;
        color: #64748b;
        margin: 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    body.dark-mode .inbox-item-snippet {
        color: #94a3b8;
    }

    .inbox-badge-locked {
        font-size: 0.65rem;
        padding: 0.15rem 0.5rem;
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
        border-radius: 99px;
        border: 1px solid rgba(239, 68, 68, 0.25);
        white-space: nowrap;
        flex-shrink: 0;
    }

    body.dark-mode .inbox-badge-locked {
        background: rgba(239, 68, 68, 0.15);
        color: #fca5a5;
        border-color: rgba(239, 68, 68, 0.3);
    }

    /* Right Column: Chat Box */
    .inbox-chat-pane {
        flex: 1;
        display: flex;
        flex-direction: column;
        min-width: 0;
        background: #ffffff;
    }

    body.dark-mode .inbox-chat-pane {
        background: rgba(15, 23, 42, 0.3);
    }

    .inbox-chat-topbar {
        padding: 1rem 1.5rem;
        background: #ffffff;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
    }

    body.dark-mode .inbox-chat-topbar {
        background: rgba(15, 23, 42, 0.8);
        border-bottom-color: rgba(255, 255, 255, 0.08);
    }

    .inbox-chat-topbar h5 {
        color: #0f172a;
        font-weight: 800;
        margin: 0;
        font-size: 1.05rem;
    }

    body.dark-mode .inbox-chat-topbar h5 {
        color: #ffffff;
    }

    .inbox-chat-topbar small {
        color: #64748b;
        font-size: 0.82rem;
    }

    body.dark-mode .inbox-chat-topbar small {
        color: #94a3b8;
    }

    .inbox-chat-topbar-info {
        display: flex;
        align-items: center;
        gap: 0.85rem;
    }

    .chat-role-badge {
        font-size: 0.7rem;
        padding: 0.15rem 0.55rem;
        background: rgba(13, 148, 136, 0.12);
        color: #0d9488;
        border-radius: 99px;
        border: 1px solid rgba(13, 148, 136, 0.3);
        margin-left: 0.5rem;
        font-weight: 700;
    }

    body.dark-mode .chat-role-badge {
        background: rgba(13, 148, 136, 0.2);
        color: #2dd4bf;
        border-color: rgba(13, 148, 136, 0.35);
    }

    .inbox-chat-messages {
        flex: 1;
        overflow-y: auto;
        padding: 1.5rem;
        background: #f8fafc;
    }

    body.dark-mode .inbox-chat-messages {
        background: transparent;
    }

    .inbox-chat-inputbar {
        padding: 1rem 1.25rem;
        background: #ffffff;
        border-top: 1px solid #e2e8f0;
    }

    body.dark-mode .inbox-chat-inputbar {
        background: rgba(15, 23, 42, 0.85);
        border-top-color: rgba(255, 255, 255, 0.08);
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

    /* Message Bubbles */
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
        background: rgba(13, 148, 136, 0.15);
        color: #0d9488;
        font-weight: 700;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    body.dark-mode .msg-avatar {
        background: rgba(255, 255, 255, 0.1);
        color: #cbd5e1;
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
        box-shadow: 0 4px 15px rgba(13, 148, 136, 0.25);
    }

    .bubble-them {
        background: #ffffff;
        color: #0f172a;
        border-bottom-left-radius: 0.2rem;
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.03);
    }

    body.dark-mode .bubble-them {
        background: #334155;
        color: #f8fafc;
        border-color: rgba(255, 255, 255, 0.08);
    }

    .msg-time {
        font-size: 0.72rem;
        color: #94a3b8;
        margin-top: 0.25rem;
        padding: 0 0.25rem;
    }

    /* Input form */
    .chat-input-form {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .chat-textarea {
        flex: 1;
        background: #f8fafc;
        border: 1px solid #cbd5e1;
        border-radius: 0.75rem;
        color: #0f172a;
        padding: 0.65rem 1rem;
        font-size: 0.95rem;
        resize: none;
        outline: none;
        transition: border-color 0.2s ease;
        font-family: inherit;
    }

    body.dark-mode .chat-textarea {
        background: rgba(30, 41, 59, 0.9);
        border-color: rgba(255, 255, 255, 0.15);
        color: #ffffff;
    }

    .chat-textarea::placeholder {
        color: #94a3b8;
    }

    .chat-textarea:focus {
        border-color: #0d9488;
        box-shadow: 0 0 0 2px rgba(13, 148, 136, 0.2);
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
        padding: 0.85rem;
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        border-radius: 0.75rem;
        color: #64748b;
        font-size: 0.9rem;
        font-weight: 600;
    }

    body.dark-mode .chat-locked-notice {
        background: rgba(255, 255, 255, 0.05);
        border-color: rgba(255, 255, 255, 0.1);
        color: #94a3b8;
    }

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

    .bg-teal-soft {
        background: rgba(13, 148, 136, 0.12);
        color: #0d9488;
        border: 1px solid rgba(13, 148, 136, 0.25);
        font-size: 0.75rem;
        padding: 0.25rem 0.75rem;
        border-radius: 99px;
        font-weight: 700;
    }

    body.dark-mode .bg-teal-soft {
        background: rgba(13, 148, 136, 0.15);
        color: #2dd4bf;
        border-color: rgba(13, 148, 136, 0.3);
    }

    .text-teal { color: #0d9488; margin-right: 0.4rem; }
    body.dark-mode .text-teal { color: #2dd4bf; }

    @media (max-width: 768px) {
        .inbox-container {
            flex-direction: column;
            height: auto;
            min-height: 580px;
        }

        .inbox-sidebar {
            width: 100%;
            max-height: 260px;
            border-right: none;
            border-bottom: 1px solid #e2e8f0;
        }

        body.dark-mode .inbox-sidebar {
            border-bottom-color: rgba(255, 255, 255, 0.08);
        }
    }
</style>
@endsection

@section('content')

<div class="inbox-page-wrapper">
    <!-- Breadcrumb Bar -->
    <div class="inbox-breadcrumb-bar">
        <div class="container-fluid px-3 px-lg-4 d-flex align-items-center justify-content-between">
            <nav style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.85rem;">
                <a href="{{ route('home') }}" class="text-decoration-none text-muted"><i class="fas fa-home me-1"></i>Home</a>
                <span class="text-muted">/</span>
                <span class="text-dark fw-bold">Live Negotiations & Messages</span>
            </nav>
            <div class="d-none d-md-flex align-items-center gap-2 text-muted" style="font-size: 0.8rem;">
                <i class="fas fa-shield-halved text-success"></i>
                <span>Direct Offer Coordination</span>
            </div>
        </div>
    </div>

    <div class="container-fluid px-3 px-lg-4">
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
                                <h5>
                                    {{ $otherParty->name ?? 'User' }}
                                    <small class="chat-role-badge">
                                        {{ ($otherParty->id === $activeOffer->listing->user_id) ? 'Seller' : 'Buyer' }}
                                    </small>
                                </h5>
                                <small>
                                    Item: <strong>{{ $activeOffer->listing->title ?? $activeOffer->listing->category }}</strong> • Offer: <strong style="color: #0d9488;">₱{{ number_format($activeOffer->bid_amount, 2) }}</strong>
                                </small>
                            </div>
                        </div>

                        <a href="{{ route('offers.show', $activeOffer) }}" class="btn btn-sm btn-outline-secondary" style="border-radius: 0.5rem; font-size: 0.82rem; font-weight: 700;">
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
                        <h4 style="font-weight: 700;">No Conversation Selected</h4>
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
