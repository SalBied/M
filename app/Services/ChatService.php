<?php

namespace App\Services;

use App\Models\Chat;
use Illuminate\Support\Facades\Auth;

class ChatService
{
    public function createChat(array $data)
    {
        $data['buyer_id'] = Auth::id();
        return Chat::create($data);
    }
}

