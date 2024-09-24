<?php

namespace App\Http\Controllers;

use App\Services\FavoriteService;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    protected $favoriteService;

    public function __construct(FavoriteService $favoriteService)
    {
        $this->favoriteService = $favoriteService;
    }

    // Add an item to favorites
    public function store(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
        ]);

        return response()->json($this->favoriteService->addFavorite($request->item_id), 201);
    }

    // Get all favorites for the user
    public function index()
    {
        return response()->json($this->favoriteService->getUserFavorites());
    }

    // Remove a favorite
    public function destroy($id)
    {
        $this->favoriteService->removeFavorite($id);
        return response()->json(['message' => 'Favorite removed']);
    }
}
