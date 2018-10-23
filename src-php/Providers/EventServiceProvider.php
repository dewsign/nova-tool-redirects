<?php

namespace Dewsign\NovaToolRedirects\Providers;

use Illuminate\Support\Facades\Event;
use Dewsign\NovaToolRedirects\Listeners\LogRedirect;
use Spatie\MissingPageRedirector\Events\RouteWasHit;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        RouteWasHit::class => [
            LogRedirect::class,
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
