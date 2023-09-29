<?php

use App\Models\Building;
use App\Models\Order;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $orders = Order::all();

        foreach ($orders as $order) {
            $streetAddress = explode(' ', $order->certificate->street_address);

            $building = new Building([
                'team_id' => $order->team_id,
                'street' => $streetAddress[0] ?? null,
                'house_number' => $streetAddress[1] ?? 1,
                'postal_code' => $order->certificate->zip,
                'city' => $order->certificate->city,
                'state' => null,
                'country' => null,
                'type' => $order->certificate->type,
                'additional_type' => $order->certificate->additional_type,
                'floor_area' => $order->certificate->floor_area,
                'floors' => $order->certificate->floors,
                'housing_units' => $order->certificate->housing_units,
                'construction_year' => $order->certificate->construction_year,
                'construction_year_heating' => $order->certificate->construction_year_heating,
                'ventilation' => $order->certificate->ventilation,
                'cooling' => $order->certificate->cooling,
                'cooling_count' => $order->certificate->cooling_count,
                'cooling_service' => $order->certificate->cooling_service,
                'layout' => $order->certificate->layout,
                'side_a' => $order->certificate->side_a,
                'side_b' => $order->certificate->side_b,
                'side_c' => $order->certificate->side_c,
                'side_d' => $order->certificate->side_d,
                'side_e' => $order->certificate->side_e,
                'maps' => $order->certificate->maps ?? 'initial',
                'orientation' => $order->certificate->orientation,
                'image' => $order->certificate->picture_path,
                'place_id' => $order->place_id,
            ]);

            $building->save();

            $order->certificate->building_id = $building->id;
            $order->certificate->save();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Order::all()->each(function ($order) {
            $order->certificate->building_id = null;
            $order->certificate->save();
        });

        Building::all()->each(function ($building) {
            $building->delete();
        });
    }
};
