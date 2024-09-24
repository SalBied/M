<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreChatRequest;
use App\Services\ChatService;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    protected $chatService;

    public function __construct(ChatService $chatService)
    {
        $this->chatService = $chatService;
    }

    public function store(StoreChatRequest $request)
    {
        return response()->json($this->chatService->createChat($request->validated()), 201);
    }
}
