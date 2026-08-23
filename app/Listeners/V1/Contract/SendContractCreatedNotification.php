<?php

namespace App\Listeners\V1\Contract;

use App\Events\Contract\ContractCreated;
use App\Notifications\BaseNotification;
use App\Traits\LocalizesNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendContractCreatedNotification implements ShouldQueue
{
    use LocalizesNotification;

    public function handle(ContractCreated $event): void
    {
        $contract = $event->contract;
        $client = $contract->client;

        if ($client && $client->user) {
            $this->withUserLocale($client->user, function () use ($contract, $client) {
                $title = __('notifications.contract_created_title');
                $body = __('notifications.contract_created_body', ['reference' => $contract->reference_number]);

                $data = [
                    'contract_id' => (string) $contract->id,
                    'type'        => 'contract_created'
                ];

                $client->user->notify(new BaseNotification($title, $body, $data));
            });
        }
    }
}
