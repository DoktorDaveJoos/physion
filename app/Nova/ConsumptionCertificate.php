<?php

namespace App\Nova;

use Illuminate\Http\Request;
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

    public function title(): string
    {
        return sprintf('%s %s', $this->zip, $this->city);
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
            MorphOne::make('Order', 'order'),

            ID::make()->sortable(),
            Text::make('Grund der Ausstellung', 'reason')->hideFromIndex(),

            new Panel('Adresse', $this->addressFields()),
            new Panel('Gebäudedaten', $this->buildingFields()),
            new Panel('Erneuerbare Energien', $this->renewableFields()),
            new Panel('Kühlung', $this->coolingFields()),

            HasMany::make('Verbrauchsdaten', 'consumptions', Consumption::class),
            HasMany::make('Leerstand', 'vacancies', Vacancy::class),

            new Panel('Zusätzlich Informationen', [
                Text::make('Feedback', 'feedback'),
                KeyValue::make('Sanierungsvorschläge Abfrage', function () {
                    return json_decode($this->suggestion_check);
                })->rules('json'),
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
            Text::make('Erneuerbare Energien', 'renewables')->copyable()->hideFromIndex(),
            Text::make('Verwendung', 'renewables_reason')->copyable()->hideFromIndex(),
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
            Text::make('Kühlung', 'cooling')->copyable()->hideFromIndex(),
            Text::make('Inspektionspflichtige Klimaanlagen', 'cooling_count')->copyable()->hideFromIndex(),
            Text::make('Nächste Inspektion', 'cooling_service')->copyable()->hideFromIndex(),
        ];
    }
}
