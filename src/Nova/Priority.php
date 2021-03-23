<?php

namespace Zareismail\NovaPriority\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\{ID, Text, Number};
use Laravel\Nova\Http\Requests\NovaRequest;
use Yna\NovaSwatches\Swatches;
use OptimistDigital\NovaSortable\Traits\HasSortableRows;

class Priority extends Resource
{
    use HasSortableRows;
    
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \Zareismail\NovaPriority\Models\NovaPriority::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'label';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'label',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),

            Text::make(__('Priority Label'), 'label')
                ->sortable()
                ->required()
                ->rules('required'),

            Swatches::make(__('Priority Color'), 'color')
                ->showFallback('color')
                ->required()
                ->rules('required'),

            Number::make(__('Primacy'), 'primacy')
                ->required()
                ->rules('required', 'unique:nova_priorities,primacy,{{resourceId}}')
                ->help(__('Large numbers have higher priority'))
                ->default(function() {
                    return static::newModel()->max('primacy') + 1;
                }),
        ];
    }

    /**
     * Return the location to redirect the user after creation.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Laravel\Nova\Resource  $resource
     * @return string
     */
    public static function redirectAfterCreate(NovaRequest $request, $resource)
    {
        return '/resources/'.static::uriKey();
    }
}
