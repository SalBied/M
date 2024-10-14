<?php

namespace App\Listeners;

namespace App\Listeners;

use App\Events\MessageSent;
use App\Models\User;
use App\Notifications\NewMessageNotification;

class SendNewMessageNotification
{
    public function handle(MessageSent $event)
    {
        $message = $event->message;
        $chat = $message->chat;

        // Determine the recipient (the other user in the chat)
        $recipient = $message->sender_id === $chat->buyer_id ? $chat->seller : $chat->buyer;

        // Send the notification to the recipient
        $sender = User::find($message->sender_id);
        $recipient->notify(new NewMessageNotification($message, $sender));
    }
}
