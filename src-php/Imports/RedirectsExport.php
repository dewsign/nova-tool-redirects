<?php

namespace Dewsign\NovaToolRedirects\Imports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Dewsign\NovaToolRedirects\Models\Redirect;
use Maatwebsite\Excel\Concerns\FromCollection;

class RedirectsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Redirect::all();
    }

    public function headings(): array
    {
        return [
            'id',
            'from',
            'to',
            'hits',
            'last_hit',
            'created_at',
            'updated_at',
        ];
    }
}
