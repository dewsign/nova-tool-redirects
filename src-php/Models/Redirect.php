<?php

namespace Dewsign\NovaToolRedirects\Models;

use Illuminate\Database\Eloquent\Model;

class Redirect extends Model
{
    protected $casts = [
        'last_hit' => 'datetime',
    ];

    protected $guarded = [];

    public static function toRedirector()
    {
        return self::all()->mapWithKeys(function ($redirect) {
            return [$redirect->from => $redirect->to];
        })->toArray();
    }
}
