<?php

namespace Dewsign\NovaToolRedirects\Nova;

use Illuminate\Bus\Queueable;
use Laravel\Nova\Actions\Action;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;
use Laravel\Nova\Fields\ActionFields;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Dewsign\NovaToolRedirects\Imports\RedirectsExport;

class ExportRedirects extends Action
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public $availableForEntireResource = true;

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        Excel::store(new RedirectsExport, $filename = __('redirects.xlsx'), 'public');

        return Action::download(Storage::disk('public')->url($filename), $filename);
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [];
    }
}
