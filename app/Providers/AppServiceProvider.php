<?php

namespace App\Providers;

use App\Models\Engineer\ConstructionReport;
use App\Models\Message;
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
    }
}
