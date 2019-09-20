<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use App\Events\ChangeEmail;
use App\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

use App\Events\MenuItemSaved;
use App\Events\MenuItemDeleted;
use App\Events\MenuSaved;
use App\Events\MenuDeleted;
use App\Listeners\ClearMenuClientCache;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        ChangeEmail::class => [
            SendEmailVerificationNotification::class,
        ],
        MenuItemSaved::class => [
            ClearMenuClientCache::class,
        ],
        MenuItemDeleted::class => [
            ClearMenuClientCache::class,
        ],
        MenuSaved::class => [
            ClearMenuClientCache::class,
        ],
        MenuDeleted::class => [
            ClearMenuClientCache::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
