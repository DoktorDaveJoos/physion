<?php

namespace App\Nova;

use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphMany;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Roof extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\EnergySource>
     */
    public static $model = \App\Models\Roof::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            BelongsTo::make('Bedarfsausweis', 'bedarfsausweis', Bdrf::class),

            Text::make('U-Wert', 'u_value'),
            Text::make('Beheizt', 'heated'),
            Text::make('Bauart', 'roof_shape'),
            Text::make('Konstruktion', 'construction'),
            Text::make('Dachneigung', 'pitch'),
            Text::make('Kniestock', 'knee_wall'),
            Text::make('Zwischendecke Stärke', 'ceiling'),

            MorphMany::make('Dämmung', 'insulations', Insulation::class),
            MorphMany::make('Fenster', 'windows', Window::class),
            HasMany::make('Gauben', 'dormers', Dormer::class),

        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
