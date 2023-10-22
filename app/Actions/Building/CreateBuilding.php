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
        string $street,
        string $houseNumber,
        string $postalCode,
        string $city,
        string $type,
        string $additionalType,
        int $constructionYear,
        int $constructionYearHeating,
        int $floorArea,
        int $floors,
        int $housingUnits,
        string $ventilation,
        string $cellar,
        ?string $cooling,
        ?int $coolingCount,
        ?string $coolingService
    ): int {
        $building = Building::create([
            'team_id' => $teamId,
            'created_by' => $userId,
            'place_id' => $placeId,
            'street' => $street,
            'house_number' => $houseNumber,
            'postal_code' => $postalCode,
            'city' => $city,
            'type' => $type,
            'additional_type' => $additionalType,
            'construction_year' => $constructionYear,
            'construction_year_heating' => $constructionYearHeating,
            'floor_area' => $floorArea,
            'floors' => $floors,
            'housing_units' => $housingUnits,
            'ventilation' => $ventilation,
            'cellar' => $cellar,
            'cooling' => $cooling,
            'cooling_count' => $coolingCount,
            'cooling_service' => $coolingService,
        ]);

        return $building->id;
    }


}
