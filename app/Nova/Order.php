<?php

namespace App\Nova;

use Exception;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\KeyValue;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;

class Order extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Order>
     */
    public static mixed $model = \App\Models\Order::class;

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
     * @throws Exception
     */
    public function fields(NovaRequest $request): array
    {
        return [
            ID::make()->sortable(),
//            Select::make('Status'),
            Badge::make('Status')->map([
                'open' => 'success',
                'clarification_needed' => 'danger',
                'done' => 'info',
            ])->labels([
                'open' => 'Offen',
                'clarification_needed' => 'In Klärung',
                'done' => 'Erledigt',
            ]),
            Boolean::make('Bezahlt', 'paid')->readonly(),
            BelongsTo::make('Kunde', 'customer', Customer::class),
            Text::make('Grund der Ausstellung', 'reason')->hideFromIndex(),
            new Panel('Adresse', $this->addressFields()),
            new Panel('Gebäudedaten', $this->buildingFields()),
            new Panel('Erneuerbare Energien', $this->renewableFields()),
            new Panel('Kühlung', $this->coolingFields()),
            HasMany::make('Verbrauchsdaten', 'consumption', Consumption::class),
            HasMany::make('Leerstand', 'vacancy', Vacancy::class),

            new Panel('Zusätzlich Informationen', [
                KeyValue::make('Sanierungsvorschläge Abfrage', function () {
                    return json_decode($this->suggestion_check);
                })->rules('json'),
            ]),

        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request): array
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
            Text::make('Postleitzahl', 'zip')->copyable(),
            Text::make('Stadt / Ort', 'city')->copyable(),
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
