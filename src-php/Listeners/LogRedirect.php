<?php

namespace Dewsign\NovaToolRedirects\Listeners;

use Dewsign\NovaToolRedirects\Listeners;
use Illuminate\Contracts\Queue\ShouldQueue;
use Dewsign\NovaToolRedirects\Models\Redirect;
use Spatie\MissingPageRedirector\Events\RouteWasHit;

class LogRedirect implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\OrderShipped  $event
     * @return void
     */
    public function handle(RouteWasHit $event)
    {
        if (!$redirect = Redirect::whereFrom($event->missingUrl)->whereTo($event->route)->first()) {
            return;
        };

        $redirect->timestamps = false;
        $redirect->hits ++;
        $redirect->last_hit = now();

        $redirect->save();
    }
}
