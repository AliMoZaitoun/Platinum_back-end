<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Services\ChatService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    use ResponseTrait;
    public function __construct(
        protected ChatService $chatService
    ) {}

    public function store(Request $request)
    {
        $request->validate([
            'chat_room_id' => 'required|exists:chat_rooms,id',
            'message_text' => 'required|string|max:5000',
        ]);

        $sender = $request->user();

        $message = $this->chatService->sendMessage($request->all(), $sender);

        return $this->successResponse($message, __('messages.common.created'));
    }
}
