<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    // Get all messages for a chat
    public function index($chat_id)
    {
        $messages = Message::where('chat_id', $chat_id)->get();
        return response()->json($messages);
    }

    // Send a new message in a chat
    public function store(Request $request, $chat_id)
    {
        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        $chat = Chat::findOrFail($chat_id);

        $user = Auth::user();
        if ($user->id !== $chat->buyer_id && $user->id !== $chat->seller_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Create the message
        $message = Message::create([
            'chat_id' => $chat_id,
            'sender_id' => $user->id,
            'content' => $validated['content'],
        ]);

        // Broadcast the message to the chat channel
        broadcast(new MessageSent($message))->toOthers();

        return response()->json($message, 201);
    }
}
