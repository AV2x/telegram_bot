<?php

namespace App\Providers;

use App\Events\ManagerOrderEvent;
use App\Events\NewOrderEvent;
use App\Events\StatusOrderEvent;
use App\Listeners\SendManagerOrderNotification;
use App\Listeners\SendNewOrderNotification;
use App\Listeners\SendStatusOrderNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        NewOrderEvent::class => [
              SendNewOrderNotification::class
        ],
        StatusOrderEvent::class => [
            SendStatusOrderNotification::class,
        ],
        ManagerOrderEvent::class => [
            SendManagerOrderNotification::class
        ]
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
