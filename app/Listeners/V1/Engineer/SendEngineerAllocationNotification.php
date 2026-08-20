<?php

namespace App\Listeners\Engineer;

use App\Events\Engineer\EngineerAllocated;
use App\Notifications\BaseNotification;
use App\Traits\LocalizesNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEngineerAllocationNotification implements ShouldQueue
{
    use LocalizesNotification;

    public function handle(EngineerAllocated $event): void
    {
        $allocation = $event->allocation;
        $engineer = $allocation->engineer;

        if ($engineer && $engineer->user) {

            $this->withUserLocale($engineer->user, function () use ($allocation, $engineer) {

                $projectName = $allocation->project->name ?? __('notifications.default_project');
                $title = __('notifications.engineer_allocation_title');

                if ($allocation->building_id) {
                    $buildingName = $allocation->building->name ?? __('notifications.default_building');
                    $body = __('notifications.engineer_allocation_building', [
                        'building' => $buildingName,
                        'project'  => $projectName,
                        'date'     => $allocation->start_date
                    ]);
                } else {
                    $body = __('notifications.engineer_allocation_project', [
                        'project' => $projectName,
                        'date'    => $allocation->start_date
                    ]);
                }

                $data = [
                    'allocation_id' => (string) $allocation->id,
                    'project_id'    => (string) $allocation->project_id,
                    'building_id'   => (string) $allocation->building_id,
                    'type'          => 'engineer_allocation'
                ];

                $engineer->user->notify(new BaseNotification($title, $body, $data, '/engineer/my-locations'));
            });
        }
    }
}
