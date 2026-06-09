<?php

namespace App\DAO;

use App\DTOs\Chat\Create\CreateRoomDTO;
use App\Models\ChatRoom;

class ChatRoomDAO
{
    public function create(CreateRoomDTO $dto): ChatRoom
    {
        return ChatRoom::create($dto->toArray());
    }

    public function findById(int $id): ?ChatRoom
    {
        return ChatRoom::find($id);
    }

    public function findActiveRoomByClient(int $client_id)
    {
        return ChatRoom::where('client_id', $client_id)->where('status', 'open')->first();
    }

    public function getClientRooms(int $client_id, int $perPage = 15)
    {
        $query = ChatRoom::query();
        $query->where('client_id', $client_id);

        return $query->with(['latestMessage'])
            ->orderBy('updated_at', 'DESC')
            ->paginate($perPage);
    }

    public function getEmployeeRooms(int $employee_id, int $perPage = 15)
    {
        $query = ChatRoom::query();
        $query->where('employee_id', $employee_id);

        return $query->with(['latestMessage'])
            ->orderBy('updated_at', 'DESC')
            ->paginate($perPage);
    }

    public function getUnassignedRooms(int $perPage = 15)
    {
        return ChatRoom::whereNull('employee_id')
            ->where('status', 'open')
            ->orderBy('created_at', 'ASC')
            ->paginate($perPage);
    }

    public function assignEmployee(int $chatRoomId, int $employeeId): bool
    {
        return ChatRoom::where('id', $chatRoomId)
            ->whereNull('employee_id')
            ->update([
                'employee_id' => $employeeId,
                'status' => 'active'
            ]) > 0;
    }
}
