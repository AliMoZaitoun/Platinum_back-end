<?php

namespace App\DAO\Report;

use App\Models\ChatRoom;
use App\Models\Sales\Complaint;
use Carbon\Carbon;

class CSRportDAO
{
    public function getComplaintAnalytics(): array
    {
        return Complaint::with('type')
            ->selectRaw('complaint_type_id, count(*) as count')
            ->groupBy('complaint_type_id')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->type->name => $item->count];
            })->toArray();
    }

    // إحصائيات غرف الدردشة
    public function getChatStats(): array
    {
        return [
            'active_chats' => ChatRoom::where('status', 'active')->count(),
            'open_chats'   => ChatRoom::where('status', 'open')->count(),
            'closed_chats' => ChatRoom::where('status', 'closed')->count(),
        ];
    }
}
