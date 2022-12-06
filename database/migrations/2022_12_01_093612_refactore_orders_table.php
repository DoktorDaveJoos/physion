<?php

use App\Models\Order;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('generals', function(Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Order::class)->constrained();

            $table->string('reason');
            $table->string('street_address');
            $table->integer('zip');
            $table->string('city');
            $table->string('building_type');
            $table->integer('construction_year');
            $table->integer('construction_year_heating');
            $table->integer('living_space');
            $table->integer('housing_units');
            $table->string('ventilation');
            $table->string('cellar');

            $table->timestamps();
        });

        Schema::create('additionals', function(Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Order::class)->constrained();

            $table->string('renewables')->nullable();
            $table->string('renewables_reason')->nullable();
            $table->string('cooling')->nullable();
            $table->integer('cooling_count')->nullable();
            $table->dateTime('cooling_service')->nullable();

            $table->json('suggestion_check')->nullable();

            $table->timestamps();
        });

        Schema::table('consumptions', function(Blueprint $table) {
            $table->string('hot_water');
        });

        foreach(Order::all() as $order) {

            DB::table('generals')->insert([
                'order_id' => $order->id,
                'reason' => $order->reason,
                'street_address' => $order->street_address,
                'zip' => $order->zip,
                'city' => $order->city,
                'building_type' => $order->building_type,
                'construction_year' => $order->construction_year,
                'construction_year_heating' => $order->construction_year_heating,
                'living_space' => $order->living_space,
                'housing_units' => $order->housing_units,
                'ventilation' => $order->ventilation,
                'cellar' => $order->cellar,
            ]);

            DB::table('additionals')->insert([
                'order_id' => $order->id,
                'renewables' => $order->renewables,
                'renewables_reason' => $order->renewables_reason,
                'cooling' => $order->cooling,
                'cooling_count' => $order->cooling_count,
                'cooling_service' => $order->cooling_service,
                'suggestion_check' => json_encode($order->suggestion_check),
            ]);

            foreach($order->consumptions as $consumption) {
                $consumption->hot_water = $order->hot_water;
                $consumption->save();
            }
        }

        Schema::table('orders', function(Blueprint $table) {
            $table->dropColumn('reason');
            $table->dropColumn('street_address');
            $table->dropColumn('zip');
            $table->dropColumn('city');
            $table->dropColumn('building_type');
            $table->dropColumn('construction_year');
            $table->dropColumn('construction_year_heating');
            $table->dropColumn('living_space');
            $table->dropColumn('housing_units');
            $table->dropColumn('ventilation');
            $table->dropColumn('cellar');
            $table->dropColumn('renewables');
            $table->dropColumn('renewables_reason');
            $table->dropColumn('cooling');
            $table->dropColumn('cooling_count');
            $table->dropColumn('cooling_service');
            $table->dropColumn('hot_water');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // noop
    }
};
