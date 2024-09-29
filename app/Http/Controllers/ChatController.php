<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    // Get all chats for the authenticated user (both as a buyer and seller)
    public function index()
    {
        $user = Auth::user();
        $chats = Chat::where('buyer_id', $user->id)
            ->orWhere('seller_id', $user->id)
            ->with('messages')
            ->get();
        return response()->json($chats);
    }

    // Create a new chat between a buyer and a seller for a specific item
    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_id' => 'required|exists:items,id',
            'seller_id' => 'required|exists:users,id',
        ]);

        $buyer_id = Auth::id(); // The authenticated user is the buyer

        // Check if a chat already exists for this item between the buyer and seller
        $chat = Chat::firstOrCreate(
            [
                'buyer_id' => $buyer_id,
                'seller_id' => $validated['seller_id'],
                'item_id' => $validated['item_id']
            ]
        );

        return response()->json($chat, 201);
    }
}
