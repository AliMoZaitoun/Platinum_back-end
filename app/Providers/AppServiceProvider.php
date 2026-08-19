<?php

namespace App\Providers;

use App\Events\Complaint\ComplaintCreated;
use App\Events\Complaint\ComplaintStatusUpdated;
use App\Events\Engineer\EngineerAllocated;
use App\Events\Order\OrderCreated;
use App\Events\Order\OrderStatusUpdated;
use App\Events\Order\OrderTransferred;
use App\Listeners\Engineer\SendEngineerAllocationNotification;
use App\Listeners\Order\SendOrderStatusNotification;
use App\Listeners\V1\Complaint\SendComplaintStatusNotification;
use App\Listeners\V1\Complaint\SendNewComplaintNotification;
use App\Listeners\V1\SendNewOrderNotification;
use App\Listeners\V1\SendOrderTransferNotification;
use App\Models\Engineer\ConstructionReport;
use App\Models\Message;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(\App\Services\TransactionService::class, \App\Services\Transaction::class);
    }

    public function boot(): void
    {
        ConstructionReport::observe(\App\Observers\V1\ConstructionReportObserver::class);
        Message::observe(\App\Observers\V1\Chat\MessageObserver::class);

        Event::listen(
            OrderTransferred::class,
            SendOrderTransferNotification::class
        );

        Event::listen(
            OrderCreated::class,
            SendNewOrderNotification::class
        );

        Event::listen(
            ComplaintCreated::class,
            SendNewComplaintNotification::class
        );

        Event::listen(
            ComplaintStatusUpdated::class,
            SendComplaintStatusNotification::class
        );

        Event::listen(
            OrderStatusUpdated::class,
            SendOrderStatusNotification::class
        );

        Event::listen(
            EngineerAllocated::class,
            SendEngineerAllocationNotification::class
        );
    }
}
