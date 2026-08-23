<?php

namespace App\Providers;

use App\Events\Complaint\ComplaintCreated;
use App\Events\Complaint\ComplaintStatusUpdated;
use App\Events\Engineer\EngineerAllocated;
use App\Events\Finance\PaymentStatusChanged;
use App\Events\Order\OrderCreated;
use App\Events\Order\OrderStatusUpdated;
use App\Events\Order\OrderTransferred;
use App\Listeners\V1\Complaint\SendComplaintStatusNotification;
use App\Listeners\V1\Complaint\SendNewComplaintNotification;
use App\Listeners\V1\Engineer\SendEngineerAllocationNotification;
use App\Listeners\V1\Finance\SendPaymentStatusNotification;
use App\Listeners\V1\Order\SendNewOrderNotification;
use App\Listeners\V1\Order\SendOrderStatusNotification;
use App\Listeners\V1\Order\SendOrderTransferNotification;
use App\Models\Engineer\ConstructionReport;
use App\Models\Message;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(\App\Services\TransactionService::class, \App\Services\Transaction::class);
    }

    public function boot(): void
    {
        ConstructionReport::observe(\App\Observers\V1\ConstructionReportObserver::class);
        Message::observe(\App\Observers\V1\Chat\MessageObserver::class);

        // Event::listen(
        //     OrderTransferred::class,
        //     SendOrderTransferNotification::class
        // );

        // Event::listen(
        //     OrderCreated::class,
        //     SendNewOrderNotification::class
        // );

        // Event::listen(
        //     ComplaintCreated::class,
        //     SendNewComplaintNotification::class
        // );

        // Event::listen(
        //     ComplaintStatusUpdated::class,
        //     SendComplaintStatusNotification::class
        // );

        // Event::listen(
        //     OrderStatusUpdated::class,
        //     SendOrderStatusNotification::class
        // );

        // Event::listen(
        //     EngineerAllocated::class,
        //     SendEngineerAllocationNotification::class
        // );

        // Event::listen(
        //     PaymentStatusChanged::class,
        //     SendPaymentStatusNotification::class
        // );

        // Event::listen(
        //     \App\Events\Contract\ContractCreated::class,
        //     \App\Listeners\V1\Contract\SendContractCreatedNotification::class
        // );

        // // إشعارات القرعة
        // Event::listen(
        //     \App\Events\Lottery\ClientsAddedToLottery::class,
        //     \App\Listeners\V1\Lottery\SendLotteryParticipationNotification::class
        // );

        // Event::listen(
        //     \App\Events\Lottery\LotteryWinnerDrawn::class,
        //     \App\Listeners\V1\Lottery\SendLotteryResultNotification::class
        // );
    }
}
