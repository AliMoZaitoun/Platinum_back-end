<?php

namespace App\Services;

use App\DAO\ChatRoomDAO;
use App\DAO\MessageDAO;
use App\DTOs\Chat\Create\CreateRoomDTO;
use App\Exceptions\V1\Chat\ChatRoomAlreadyAssignedException;
use App\Exceptions\V1\Chat\ChatRoomNotFoundException;
use App\Exceptions\V1\Chat\UnauthorizedChatAccessException;

class ChatService
{
    public function __construct(
        protected ChatRoomDAO $chatRoomDAO,
        protected MessageDAO $messageDAO
    ) {}

    public function createNewRoom(int $clientId)
    {
        $existingRoom = $this->chatRoomDAO->findActiveRoomByClient($clientId);

        if ($existingRoom) {
            return $existingRoom;
        }

        $dto = CreateRoomDTO::fromRequest($clientId);
        return $this->chatRoomDAO->create($dto);
    }

    public function authorizeRoomAccess(int $userId, int $chatRoomId): bool
    {
        $room = $this->getVerifiedRoom($chatRoomId);

        $isClient = (int) $userId === (int) $room->client_id;
        $isEmployee  = (int) $userId === (int) $room->employee_id;

        if (!$isClient && !$isEmployee) {
            throw new UnauthorizedChatAccessException();
        }

        return true;
    }

    private function getVerifiedRoom(int $chatRoomId)
    {
        $room = $this->chatRoomDAO->findById($chatRoomId);

        if (!$room) {
            throw new ChatRoomNotFoundException();
        }

        return $room;
    }

    public function getActiveRooms(int $sender_id, string $sender_type, int $perPage = 15)
    {
        if ($sender_type == 'employee') {
            return $this->chatRoomDAO->getEmployeeRooms($sender_id, $perPage);
        }
        return $this->chatRoomDAO->getClientRooms($sender_id, $perPage);
    }

    public function claimRoom(int $chatRoomId, int $employeeId): void
    {
        $success = $this->chatRoomDAO->assignEmployee($chatRoomId, $employeeId);

        if (!$success) {
            throw new ChatRoomAlreadyAssignedException();
        }
    }

    public function getWaitingRooms(int $perPage = 15)
    {
        return $this->chatRoomDAO->getUnassignedRooms($perPage);
    }
}
