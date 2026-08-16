<?php

namespace App\Listeners\Engineer;

use App\Events\Engineer\EngineerAllocated;
use App\Notifications\BaseNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEngineerAllocationNotification implements ShouldQueue
{
    public function handle(EngineerAllocated $event): void
    {
        $allocation = $event->allocation;
        $engineer = $allocation->engineer;

        if ($engineer && $engineer->user) {

            $projectName = $allocation->project->name ?? 'المشروع المحدد';

            if ($allocation->building_id) {
                $buildingName = $allocation->building->name ?? 'المبنى المحدد';
                $body = "تم إسنادك للإشراف الميداني على '{$buildingName}' ضمن '{$projectName}'. تبدأ المهمة بتاريخ {$allocation->start_date}.";
            } else {
                $body = "تم إسنادك للإشراف الميداني على '{$projectName}' بالكامل. تبدأ المهمة بتاريخ {$allocation->start_date}.";
            }

            $title = "🏗️ مهمة هندسية جديدة";
            $data = [
                'allocation_id' => (string) $allocation->id,
                'project_id'    => (string) $allocation->project_id,
                'building_id'   => (string) $allocation->building_id,
                'type'          => 'engineer_allocation'
            ];

            $engineer->user->notify(new BaseNotification($title, $body, $data, '/engineer/my-locations'));
        }
    }
}
