<?php

namespace App\Providers;

use App\Domains\Users\Events\UserCreated;
use App\Domains\Users\Listeners\SendWelcomeEmail;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [];
}



