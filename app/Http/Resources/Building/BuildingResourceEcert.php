<?php

declare(strict_types=1);

namespace App\Http\Resources\Building;

use App\Http\Resources\EnergyCertificateResource;
use App\Models\Building;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Building
 */
class BuildingResourceEcert extends JsonResource
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
                    'vrbr' => EnergyCertificateResource::make(
                        $this->energyCertificates()->where('type', 'vrbr')->first()
                    ),
                    'bdrf' => EnergyCertificateResource::make(
                        $this->energyCertificates()->where('type', 'bdrf')->first()
                    ),
                ],
                'thermal' => $this->thermalDone(),
                'heating' => $this->heatingDone(),
                'renewable' => $this->renewableDone(),
                'consumption' => $this->consumptionDone(),
            ],
            'links' => [
                'self' => null, //route('hub.buildings.show.index', $this->id),
            ],
        ];
    }
}
