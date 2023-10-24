<?php

declare(strict_types=1);

namespace App\Actions\Building;

use App\Models\Building;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateBuilding
{

    use asAction;

    public function handle(
        int $teamId,
        int $userId,
        string $placeId,
        bool $newBuilding,
        string $street,
        string $houseNumber,
        string $postalCode,
        string $city,
        string $type,
        ?string $additionalType,
        int $constructionYear,
        int $floorArea,
        ?int $landArea,
        ?int $floors,
        ?int $floor,
        ?int $rooms,
        ?int $housingUnits,
        string $ventilation,
        ?string $cooling,
        ?int $coolingCount,
        ?string $coolingService
    ): int {
        $building = Building::create([
            'team_id' => $teamId,
            'created_by' => $userId,
            'place_id' => $placeId,
            'new_building' => $newBuilding,
            'street' => $street,
            'house_number' => $houseNumber,
            'postal_code' => $postalCode,
            'city' => $city,
            'type' => $type,
            'additional_type' => $additionalType,
            'construction_year' => $constructionYear,
            'floor_area' => $floorArea,
            'land_area' => $landArea,
            'floors' => $floors,
            'floor' => $floor,
            'rooms' => $rooms,
            'housing_units' => $housingUnits,
            'ventilation' => $ventilation,
            'cooling' => $cooling,
            'cooling_count' => $coolingCount,
            'cooling_service' => $coolingService,
        ]);

        return $building->id;
    }
}
