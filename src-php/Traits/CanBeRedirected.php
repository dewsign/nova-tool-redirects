<?php

namespace Dewsign\NovaToolRedirects\Traits;

trait CanBeRedirected
{
    /**
     * Retrieve the model for a bound value.
     *
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value)
    {
        $redirectResponse = app(\Spatie\MissingPageRedirector\MissingPageRouter::class)->getRedirectFor(request());

        return $this->where($this->getRouteKeyName(), $value)->first() ?? abort($redirectResponse) ?? abort(404);
    }
}