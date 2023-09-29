<?php

declare(strict_types=1);

namespace App\Http\Resources\Building;

use App\Models\Building;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

/**
 * @mixin Building
 */
class BuildingThermalResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'data' => [
                'id' => $this->id,
                'address' => $this->street.' '.$this->house_number,
                'postal_code' => $this->postal_code,
                'city' => $this->city,
                'state' => $this->state,
                'country' => $this->country,
                'type' => $this->type,
                'additional_type' => $this->additional_type,
                'floor_area' => $this->floor_area,
                'floors' => $this->floors,
                'housing_units' => $this->housing_units,
                'construction_year' => $this->construction_year,
                'construction_year_heating' => $this->construction_year_heating,
                'cellar' => $this->cellar,
                'ventilation' => $this->ventilation,
                'cooling' => $this->cooling,
                'cooling_count' => $this->cooling_count,
                'cooling_service' => $this->cooling_service,
                'layout' => $this->layout->toString(),
                'side_a' => $this->side_a,
                'side_b' => $this->side_b,
                'side_c' => $this->side_c,
                'side_d' => $this->side_d,
                'side_e' => $this->side_e,
                'maps' => $this->maps,
                'orientation' => $this->orientation,
                'place_id' => $this->place_id,
                'created_by' => 'David Joos', //@todo
                'wall' => $this->wall?->load('insulations', 'windows'),
                'roof' => $this->roof?->load('insulations', 'windows', 'dormers'),
                'cellarModel' => $this->cellarObject?->load('insulations'),
            ],
            'links' => [
                'self' => route('hub.buildings.show', $this->id),
            ],
        ];
    }
}
