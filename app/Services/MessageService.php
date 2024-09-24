<?php

namespace App\Services;

use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class MessageService
{
    public function createMessage($chatId, array $data)
    {
        $data['sender_id'] = Auth::id();
        $data['chat_id'] = $chatId;
        return Message::create($data);
    }
}
