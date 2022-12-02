<?php

namespace App\Nova;


use App\Nova\Metrics\MoneyGained;
use App\Nova\Metrics\NewOrders;
use Exception;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\Select;
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

    public static $group = 'Bestellungen';

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
            Select::make('Status')->options([
                'open' => 'Offen',
                'awaiting_payment' => 'Ausstehend',
                'clarification_needed' => 'In Klärung',
                'done' => 'Erledigt',
            ])->onlyOnForms(),
            Badge::make('Status')->map([
                'open' => 'success',
                'awaiting_payment' => 'warning',
                'clarification_needed' => 'danger',
                'done' => 'info',
            ])->labels([
                'open' => 'Offen',
                'awaiting_payment' => 'Ausstehend',
                'clarification_needed' => 'In Klärung',
                'done' => 'Erledigt',
            ]),
            Boolean::make('Bezahlt', 'paid')->readonly(),
            BelongsTo::make('Kunde', 'customer', Customer::class),

            MorphTo::make('Produkt', 'product')->types([
                ConsumptionCertificate::class,
            ])
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
        return [
            new NewOrders,
            new MoneyGained,
        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request): array
    {
        return [
            new Filters\OrderStatus,
            new Filters\OrderPaid,
        ];
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
}
