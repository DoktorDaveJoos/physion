<?php

declare(strict_types=1);

namespace App\Actions\Building;

use App\Models\Building;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateBuilding
{

    use asAction;

    public function handle(
        Building $building,
        string $placeId = null,
        string $street = null,
        string $houseNumber = null,
        string $postalCode = null,
        string $city = null,
        string $type = null,
        string $additionalType = null,
        int $constructionYear = null,
        int $constructionYearHeating = null,
        int $floorArea = null,
        int $floors = null,
        int $housingUnits = null,
        string $ventilation = null,
        string $cellar = null,
        string $cooling = null,
        int $coolingCount = null,
        string $coolingService = null
    ): int {
        if ($placeId) {
            $building->place_id = $placeId;
        }
        if ($street) {
            $building->street = $street;
        }
        if ($houseNumber) {
            $building->house_number = $houseNumber;
        }
        if ($postalCode) {
            $building->postal_code = $postalCode;
        }
        if ($city) {
            $building->city = $city;
        }
        if ($type) {
            $building->type = $type;
        }
        if ($additionalType) {
            $building->additional_type = $additionalType;
        }
        if ($constructionYear) {
            $building->construction_year = $constructionYear;
        }
        if ($constructionYearHeating) {
            $building->construction_year_heating = $constructionYearHeating;
        }
        if ($floorArea) {
            $building->floor_area = $floorArea;
        }
        if ($floors) {
            $building->floors = $floors;
        }
        if ($housingUnits) {
            $building->housing_units = $housingUnits;
        }
        if ($ventilation) {
            $building->ventilation = $ventilation;
        }
        if ($cellar) {
            $building->cellar = $cellar;
        }
        if ($cooling) {
            $building->cooling = $cooling;
        }
        if ($coolingCount) {
            $building->cooling_count = $coolingCount;
        }
        if ($coolingService) {
            $building->cooling_service = $coolingService;
        }

        $building->save();

        return $building->id;
    }


}
