<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Chat;
use Illuminate\Support\Facades\Route;


Broadcast::channel('chat.{chatId}', function ($user, $chatId) {
    $chat = Chat::find($chatId);
    // Only allow the buyer or the seller in the chat to listen to this channel
    return $chat && ($chat->buyer_id === $user->id || $chat->seller_id === $user->id);
});


