<?php

use App\Models\Customer;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
        Schema::create('orders', function (Blueprint $table) {
//            Database related
            $table->id();
            $table->timestamps();
//            Basic building
            $table->string('reason');
            $table->string('street_address');
            $table->string('zip');
            $table->string('city');
            $table->string('building_type');
            $table->string('construction_year');
            $table->string('construction_year_heating');
            $table->string('living_space');
            $table->string('housing_units');
            $table->string('ventilation');
            $table->string('cellar');
//            Additional building
            $table->string('renewables')->nullable();
            $table->string('renewables_reason')->nullable();
            $table->string('cooling')->nullable();
            $table->string('cooling_count')->nullable();
            $table->date('cooling_service')->nullable();
//            Water
            $table->string('hot_water');
//            Order and Customer
            $table->foreignIdFor(Customer::class)->nullable()->constrained();
            $table->boolean('paid')->default(false);
            $table->string("payment_intent")->unique()->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
