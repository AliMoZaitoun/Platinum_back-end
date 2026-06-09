<?php

namespace App\Http\Controllers\V1;

use App\Exceptions\V1\Chat\OnlyEmployeeCanClaimException;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Chat\SendMessageRequest;
use App\Http\Resources\V1\Chat\ChatRoomResource;
use App\Http\Resources\V1\Chat\MessageResource;
use App\Services\ChatService;
use App\Services\MessageService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    use ResponseTrait;
    public function __construct(
        private ChatService $chatService,
        private MessageService $messageService
    ) {}

    public function index(Request $request)
    {
        $user = $request->user();
        $perPage = $request->query('per_page', 15);

        $rooms = $this->chatService->getActiveRooms($user->sender->id, $user->type, $perPage);

        return $this->successCollection($rooms, ChatRoomResource::class);
    }

    public function createRoom(Request $request)
    {
        $client = $request->user()->client;
        $room = $this->chatService->createNewRoom($client->id);

        return $this->useResource($room, ChatRoomResource::class, __('messages.common.created'), 201);
    }

    public function store(SendMessageRequest $request)
    {
        $user = $request->user();

        $roomId = $request->chat_room_id;

        $this->chatService->authorizeRoomAccess($user->sender->id, $roomId);

        $message = $this->messageService->sendMessage(
            $request->validated(),
            $user->sender->id,
            $user->type
        );

        return $this->successResponse($message, __('messages.common.created'));
    }

    public function getMessages(Request $request, int $roomId)
    {
        $user = $request->user()->sender;

        $this->chatService->authorizeRoomAccess($user->id, $roomId);

        $messages = $this->messageService->getRoomMessagesArchive($roomId);

        return $this->successCollection($messages, MessageResource::class);
    }

    public function unassignedRooms(Request $request)
    {
        $perPage = $request->query('per_page', 15);
        $rooms = $this->chatService->getWaitingRooms($perPage);

        return $this->successCollection($rooms, ChatRoomResource::class);
    }

    public function claim(Request $request, int $roomId)
    {
        $user = $request->user()->sender;

        $this->chatService->claimRoom($roomId, $user->id);

        return $this->successResponse(null, __('messages.chat.room_claimed_success'));
    }
}
