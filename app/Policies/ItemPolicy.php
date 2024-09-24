<?php


namespace App\Policies;

use App\Models\User;
use App\Models\Item;

class ItemPolicy
{
    public function update(User $user, Item $item)
    {

        return $user->id === $item->seller_id;
    }

    public function delete(User $user, Item $item)
    {
        return $user->id === $item->seller_id;
    }
}
