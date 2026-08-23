<?php

namespace App\Listeners\V1\Lottery;

use App\Events\Lottery\LotteryWinnerDrawn;
use App\Notifications\BaseNotification;
use App\Models\Lottery\LotteryParticipant;
use App\Traits\LocalizesNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendLotteryResultNotification implements ShouldQueue
{
    use LocalizesNotification;

    public function handle(LotteryWinnerDrawn $event): void
    {
        $lottery = $event->lottery;

        $participants = LotteryParticipant::where('lottery_id', $lottery->id)
            ->with('client.user')
            ->get();

        foreach ($participants as $participant) {
            if ($participant->client && $participant->client->user) {
                $this->withUserLocale($participant->client->user, function () use ($lottery, $participant) {

                    $isWinner = $participant->client_id === $lottery->winner_client_id;

                    if ($isWinner) {
                        $title = __('notifications.lottery_winner_title');
                        $body = __('notifications.lottery_winner_body');
                    } else {
                        $title = __('notifications.lottery_loser_title');
                        $body = __('notifications.lottery_loser_body');
                    }

                    $data = [
                        'lottery_id' => (string) $lottery->id,
                        'is_winner'  => $isWinner,
                        'type'       => 'lottery_result'
                    ];

                    $participant->client->user->notify(new BaseNotification($title, $body, $data));
                });
            }
        }
    }
}
