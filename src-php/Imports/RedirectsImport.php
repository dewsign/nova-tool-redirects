<?php

namespace Dewsign\NovaToolRedirects\Imports;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Dewsign\NovaToolRedirects\Models\Redirect;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RedirectsImport implements ToCollection, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return User|null
     */
    public function collection(Collection $rows)
    {
        $rows->each(function ($row) {
            $from = Arr::get($row, 'from');
            $to = Arr::get($row, 'to');

            if (!$redirect = Redirect::whereFrom($from)->first()) {
                return Redirect::create([
                    'from' => $from,
                    'to' => $to,
                ]);
            }

            $redirect->to = $to;
            $redirect->save();
        });
    }
}
