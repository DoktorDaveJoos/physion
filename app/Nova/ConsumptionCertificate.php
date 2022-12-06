<?php

namespace App\Nova;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\KeyValue;
use Laravel\Nova\Fields\MorphOne;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;

class ConsumptionCertificate extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\ConsumptionCertificate>
     */
    public static mixed $model = \App\Models\ConsumptionCertificate::class;

    public static $group = 'Detail';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    public static function label()
    {
        return 'Verbrauchsausweise';
    }

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
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            MorphOne::make('Order', 'order')->showOnIndex(),

            ID::make()->sortable(),
            Text::make('Grund der Ausstellung', 'reason')->hideFromIndex(),

            new Panel('Adresse', $this->addressFields()),
            new Panel('Gebäudedaten', $this->buildingFields()),
            new Panel('Erneuerbare Energien', $this->renewableFields()),
            new Panel('Kühlung', $this->coolingFields()),

            HasMany::make('Verbrauchsdaten', 'consumptions', Consumption::class)->readonly(),
            HasMany::make('Leerstand', 'vacancies', Vacancy::class),

            new Panel('Vorschlagsmaxtrix', [
                KeyValue::make('Sanierungsvorschläge Abfrage', function () {
                    return $this->additional->suggestion_check;
                })->rules('array'),
            ]),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the address fields for the resource.
     *
     * @return array
     * @throws Exception
     */
    protected function addressFields(): array
    {
        return [
            Text::make('Straße', 'street_address')->copyable(),
            Text::make('Postleitzahl & Ort', function() {
                return sprintf('%s %s', $this->zip, $this->city);
            })->copyable(),
        ];
    }

    /**
     * Get the address fields for the resource.
     *
     * @return array
     * @throws Exception
     */
    protected function buildingFields(): array
    {
        return [
            Text::make('Gebäudetyp', 'building_type')->copyable()->hideFromIndex(),
            Text::make('Baujahr', 'construction_year')->copyable()->hideFromIndex(),
            Text::make('Baujahr Heizung', 'construction_year_heating')->copyable()->hideFromIndex(),
            Text::make('Wohnfläche', 'living_space')->copyable()->hideFromIndex(),
            Text::make('Wohneinheiten', 'housing_units')->copyable()->hideFromIndex(),
            Text::make('Lüftung', 'ventilation')->copyable()->hideFromIndex(),
            Text::make('Keller', 'cellar')->copyable()->hideFromIndex(),

        ];
    }

    /**
     * Get the address fields for the resource.
     *
     * @return array
     * @throws Exception
     */
    protected function renewableFields(): array
    {
        return [
            Text::make('Erneuerbare Energien', function() {
                return $this->additional->renewables;
            })->copyable()->hideFromIndex(),
            Text::make('Verwendung', function() {
                return $this->additional->renewables_reason;
            })->copyable()->hideFromIndex(),
        ];
    }

    /**
     * Get the address fields for the resource.
     *
     * @return array
     * @throws Exception
     */
    protected function coolingFields(): array
    {
        return [
            Text::make('Kühlung', function() {
                return $this->additional->cooling;
            })->copyable()->hideFromIndex(),
            Text::make('Inspektionspflichtige Klimaanlagen', function() {
                return $this->additional->cooling_count;
            })->copyable()->hideFromIndex(),
            Text::make('Nächste Inspektion', function() {
                Return $this->additional->cooling_service ? Carbon::parse($this->additional->cooling_service)->format('d.m.Y') : null;
            })->copyable()->hideFromIndex()
        ];
    }
}
