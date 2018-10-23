<?php

namespace Dewsign\NovaToolRedirects\Nova;

use Illuminate\Bus\Queueable;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Actions\Action;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;
use Laravel\Nova\Fields\ActionFields;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Dewsign\NovaToolRedirects\Imports\RedirectsImport;

class ImportRedirects extends Action
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
        if (!$file = $fields->redirects) {
            return Action::danger(__('No file was uploaded'));
        }

        try {
            Excel::import(new RedirectsImport, $file);

            return Action::message(__('Redirects imported successfully'));
        } catch (\Exception $e) {
            return Action::danger(__('Unable to import redirects'));
        }
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [
            File::make('Redirects')->rules('required'),
        ];
    }
}
