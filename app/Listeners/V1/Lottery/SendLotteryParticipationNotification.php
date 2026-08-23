<?php

namespace App\Listeners\V1\Lottery;

use App\Events\Lottery\ClientsAddedToLottery;
use App\Notifications\BaseNotification;
use App\Models\Client\Client;
use App\Traits\LocalizesNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendLotteryParticipationNotification implements ShouldQueue
{
    use LocalizesNotification;

    public function handle(ClientsAddedToLottery $event): void
    {
        $lottery = $event->lottery;
        $clients = Client::whereIn('id', $event->clientIds)->with('user')->get();

        foreach ($clients as $client) {
            if ($client->user) {
                $this->withUserLocale($client->user, function () use ($lottery, $client) {
                    $title = __('notifications.lottery_participation_title');
                    $body = __('notifications.lottery_participation_body', ['unit' => $lottery->unit_id]);

                    $data = [
                        'lottery_id' => (string) $lottery->id,
                        'type'       => 'lottery_participation'
                    ];

                    $client->user->notify(new BaseNotification($title, $body, $data));
                });
            }
        }
    }
}
