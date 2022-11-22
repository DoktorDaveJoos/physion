<?php

namespace App\Nova\Filters;

use Illuminate\Database\Eloquent\Builder;
use JetBrains\PhpStorm\ArrayShape;
use Laravel\Nova\Filters\BooleanFilter;
use Laravel\Nova\Http\Requests\NovaRequest;

class OrderStatus extends BooleanFilter
{
    /**
     * Apply the filter to the given query.
     *
     * @param  NovaRequest  $request
     * @param  Builder  $query
     * @param  mixed  $value
     * @return Builder
     */
    public function apply(NovaRequest $request, $query, $value): Builder
    {

        $states = [];
        foreach ($value as $key => $val) {
            if ($val) {
                $states[] = $key;
            }
        }

        if (count($states) == 0) {
            return $query;
        }

        return $query->whereIn('status', $states);
    }

    /**
     * Get the filter's available options.
     *
     * @param  NovaRequest  $request
     * @return array
     */
    public function options(NovaRequest $request): array
    {
        return [
            'Offen' => 'open',
            'In Klärung' => 'clarification_needed',
            'Erledigt' => 'done',
        ];
    }
}
