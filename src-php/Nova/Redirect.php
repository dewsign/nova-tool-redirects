<?php

namespace Dewsign\NovaToolRedirects\Nova;

use Laravel\Nova\Resource;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\DateTime;
use Dewsign\NovaToolRedirects\Nova\ExportRedirects;
use Dewsign\NovaToolRedirects\Nova\ImportRedirects;

class Redirect extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'Dewsign\NovaToolRedirects\Models\Redirect';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'from',
        'to',
    ];

    public function title()
    {
        return sprintf('%s > %s', $this->from, $this->to);
    }

    public static function label()
    {
        return __('Redirects');
    }

    public static function group()
    {
        return config('nova-tool-redirects.resourceGroup', 'Other');
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            Text::make('From')->rules('required', 'max:254')->sortable(),
            Text::make('To')->rules('required', 'max:254')->sortable(),
            Number::make('Hits')->exceptOnForms()->sortable(),
            Date::make('Last Hit')->exceptOnForms()->sortable()->resolveUsing(function ($date) {
                return optional($date)->diffForHumans();
            }),
            DateTime::make('Created At')->onlyOnDetail(),
            DateTime::make('Updated At')->onlyOnDetail(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [
            (new ImportRedirects)->availableForEntireResource(),
            (new ExportRedirects)->availableForEntireResource(),
        ];
    }
}
