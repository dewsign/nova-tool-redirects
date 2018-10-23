<?php

namespace Dewsign\NovaToolRedirects;

use Symfony\Component\HttpFoundation\Request;
use Dewsign\NovaToolRedirects\Models\Redirect;
use Spatie\MissingPageRedirector\Redirector\Redirector;

class NovaRedirector implements Redirector
{
    public function getRedirectsFor(Request $request): array
    {
        return Redirect::toRedirector();
    }
}
