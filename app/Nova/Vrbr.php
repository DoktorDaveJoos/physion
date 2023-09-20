<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Exceptions\HelperNotSupported;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\KeyValue;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Storage;

class Vrbr extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<Verbrauchsausweise>
     */
    public static $model = \App\Models\Vrbr::class;

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
     * @throws HelperNotSupported
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),
            Text::make('Order ID', 'order.slug'),
            Text::make('Grund der Ausstellung', 'reason'),

            Image::make('Gebäudebild', 'picture_path')->disk('digitalocean')->download(function($request, $model, $disk, $value) {
                ob_end_clean();
                return Storage::disk($disk)->download($this->picture_path, $this->street_address . '_' . $this->zip . '_' . $this->city . '.jpg');
            }),

            new Panel('Adresse', [
                Text::make('Straße', 'street_address')->copyable(),
                Text::make('Postleitzahl & Ort', function() {
                    return $this->zip . ' ' . $this->city;
                })->copyable(),
            ]),

            new Panel('Gebäudedaten', [
                Text::make('Gebäudetyp', 'type')->copyable()->hideFromIndex(),
                Text::make('Art', 'additional_type')->copyable()->hideFromIndex(),
                Text::make('Baujahr', 'construction_year')->copyable()->hideFromIndex(),
                Text::make('Baujahr Heizung', 'construction_year_heating')->copyable()->hideFromIndex(),
                Text::make('Wohnfläche', 'floor_area')->copyable()->hideFromIndex(),
                Text::make('Anzahl Wohneinheiten', 'housing_units')->copyable()->hideFromIndex(),
                Text::make('Lüftung', 'ventilation')->copyable()->hideFromIndex(),
                Text::make('Keller', 'cellar')->copyable()->hideFromIndex(),
            ]),

            new Panel('Erneuerbare Energien', [
                Text::make('Erneuerbare Energien', 'renewables')->copyable()->hideFromIndex(),
                Text::make('Verwendung', 'renewables_reason')->copyable()->hideFromIndex(),
            ]),

            new Panel('Kühlung', [
                Text::make('Kühlung', 'cooling')->copyable()->hideFromIndex(),
                Text::make('Inspektionspflichtige Klimaanlagen', 'cooling_count')->copyable()->hideFromIndex(),
                Date::make('Nächste Inspektion', 'cooling_service')->hideFromIndex(),
            ]),

            HasMany::make('Energieträger', 'sources', EnergySource::class),

            HasMany::make('Leerstand', 'vacancies', Vacancy::class),

            KeyValue::make('Vorschlagsmatrix', 'suggestion_check')->rules('json')->hideFromIndex(),

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
