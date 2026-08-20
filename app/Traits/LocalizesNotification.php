<?php

namespace App\Traits;

use Illuminate\Support\Facades\App;

trait LocalizesNotification
{
    public function withUserLocale($user, callable $callback)
    {
        if (!$user) {
            return $callback();
        }

        $originalLocale = App::getLocale();

        App::setLocale($user->locale ?? 'ar');

        $callback();

        App::setLocale($originalLocale);
    }
}
