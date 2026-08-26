<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Notification;
use App\Models\Offer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ChatController extends Controller
{
    /**
     * Dedicated Messenger / Messages Inbox.
     */
    public function inbox(Request $request): View
    {
        $user = Auth::user();

        // Get all offers where the user is buyer or seller, and offer was at least accepted
        $offers = Offer::with(['listing.seller', 'buyer', 'messages' => function ($q) {
            $q->latest();
        }])
            ->where(function ($query) use ($user) {
                $query->where('buyer_id', $user->id)
                    ->orWhereHas('listing', function ($lq) use ($user) {
                        $lq->where('user_id', $user->id);
                    });
            })
            ->whereIn('status', ['accepted', 'completed', 'cancelled'])
            ->orderBy('updated_at', 'desc')
            ->get();

        $selectedOfferId = $request->query('offer_id');
        $activeOffer = $selectedOfferId
            ? $offers->firstWhere('id', $selectedOfferId)
            : $offers->first();

        if ($activeOffer) {
            // Mark incoming unread messages as read
            $activeOffer->messages()
                ->where('receiver_id', $user->id)
                ->where('is_read', false)
                ->update([
                    'is_read' => true,
                    'read_at' => now(),
                ]);
        }

        return view('messages.index', compact('offers', 'activeOffer'));
    }

    /**
     * Fetch messages for live polling in an offer chat thread.
     */
    public function fetch(Offer $offer, Request $request): JsonResponse
    {
        $user = Auth::user();

        // Verify participant
        if (!$this->isParticipant($offer, $user->id) && !$user->isAdmin()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Mark incoming unread messages as read
        $offer->messages()
            ->where('receiver_id', $user->id)
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);

        $afterId = $request->query('after_id');
        $query = $offer->messages()->with('sender:id,name,role');

        if ($afterId) {
            $query->where('id', '>', $afterId);
        }

        $messages = $query->orderBy('created_at', 'asc')->get();

        return response()->json([
            'messages' => $messages->map(function ($msg) use ($user) {
                return [
                    'id' => $msg->id,
                    'sender_id' => $msg->sender_id,
                    'sender_name' => $msg->sender?->name ?? 'User',
                    'is_me' => $msg->sender_id === $user->id,
                    'message' => $msg->message,
                    'created_at' => $msg->created_at->format('M d, Y h:i A'),
                    'time_ago' => $msg->created_at->diffForHumans(),
                    'is_read' => $msg->is_read,
                ];
            }),
            'is_chat_active' => $offer->isChatActive(),
            'is_chat_locked' => $offer->isChatLocked(),
            'status' => $offer->status,
        ]);
    }

    /**
     * Send a new message in the offer conversation.
     */
    public function store(Request $request, Offer $offer): JsonResponse
    {
        $user = Auth::user();

        // Verify participant
        if (!$this->isParticipant($offer, $user->id)) {
            return response()->json(['error' => 'Unauthorized to message in this offer'], 403);
        }

        // Check if chat is active (offer accepted and transaction not finished)
        if (!$offer->isChatActive()) {
            return response()->json([
                'error' => 'This conversation is locked because the transaction is completed or not yet accepted.',
                'is_chat_locked' => true,
            ], 403);
        }

        $validated = $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        $receiverId = ($user->id === $offer->buyer_id)
            ? $offer->listing->user_id
            : $offer->buyer_id;

        $message = Message::create([
            'offer_id' => $offer->id,
            'sender_id' => $user->id,
            'receiver_id' => $receiverId,
            'message' => trim($validated['message']),
            'is_read' => false,
        ]);

        // Send notification to receiver
        $receiver = ($user->id === $offer->buyer_id) ? $offer->listing->seller : $offer->buyer;
        if ($receiver) {
            Notification::notify(
                $receiver,
                'new_message',
                'New Message from ' . $user->name,
                mb_strimwidth($message->message, 0, 80, '...'),
                [
                    'offer_id' => $offer->id,
                    'sender_name' => $user->name,
                    'listing_title' => $offer->listing->title ?? $offer->listing->category,
                ]
            );
        }

        return response()->json([
            'success' => true,
            'message' => [
                'id' => $message->id,
                'sender_id' => $message->sender_id,
                'sender_name' => $user->name,
                'is_me' => true,
                'message' => $message->message,
                'created_at' => $message->created_at->format('M d, Y h:i A'),
                'time_ago' => $message->created_at->diffForHumans(),
                'is_read' => false,
            ],
        ]);
    }

    /**
     * Check if user is buyer or seller of the offer.
     */
    private function isParticipant(Offer $offer, int $userId): bool
    {
        return $offer->buyer_id === $userId || $offer->listing?->user_id === $userId;
    }
}
