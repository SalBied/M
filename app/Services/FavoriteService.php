<?php

namespace App\Services;

use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;

class FavoriteService
{
    public function addFavorite($itemId)
    {
        return Favorite::create([
            'user_id' => Auth::id(),
            'item_id' => $itemId,
        ]);
    }

    public function removeFavorite($favoriteId)
    {
        $favorite = Auth::user()->favorites()->where('id', $favoriteId)->first();

        if (! $favorite) {
            throw new ModelNotFoundException('Favorite not found');
        }

        $favorite->delete();
        return true;
    }

    public function getUserFavorites()
    {
        return Auth::user()->favorites()->with('item')->get();
    }
}
