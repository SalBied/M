<?php

namespace App\Broadcasting;

use App\Models\User;

class chat
{
    /**
     * Create a new channel instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Authenticate the user's access to the channel.
     */
    public function join(User $user, \App\Models\Chat $chat): array|bool
    {
   
        return $chat && ($chat->buyer_id === $user->id || $chat->seller_id === $user->id);

    }
}
