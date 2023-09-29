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
class BuildingResourceEnergieausweis extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'data' => [
                'id' => $this->id,
                'address' => $this->street.' '.$this->house_number,
                'postal_code' => $this->postal_code,
                'city' => $this->city,
                'products' => [
                    'vrbr' => $this->vrbr,
                    'bdrf' => $this->bdrf,
                ],
                'wall' => (bool) $this->wall,
                'roof' => (bool) $this->roof,
                'cellarModel' => (bool) $this->cellarObject,
                'heatingSystems' => $this->heatingSystems,
                'renewableEnergyInstallations' => $this->renewableEnergyInstallations,
            ],
            'links' => [
                'self' => route('hub.buildings.show.index', $this->id),
            ],
        ];
    }
}
