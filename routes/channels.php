<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Chat;
use Illuminate\Support\Facades\Route;


Broadcast::channel('chat.{chatId}', function ($user, $chatId) {
   dd(2);
    $chat = Chat::find($chatId);
    logger('f u b a');
    // Only allow the buyer or the seller in the chat to listen to this channel
    return $chat && ($chat->buyer_id === $user->id || $chat->seller_id === $user->id);
});

Broadcast::channel('c', function () {
    logger('f u b');
    return false; // Public channel, always allow subscription
});
Broadcast::channel('chats.{chat}', \App\Broadcasting\chat::class);
