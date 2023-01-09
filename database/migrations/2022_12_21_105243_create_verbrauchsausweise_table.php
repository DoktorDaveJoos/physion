<?php

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
        Schema::create('verbrauchsausweise', function (Blueprint $table) {
            $table->id();

            $table->string('reason');
            $table->string('street_address');
            $table->string('zip');
            $table->string('city');

            $table->string('type');
            $table->string('additional_type');

            $table->integer('floor_area')->nullable();
            $table->integer('housing_units')->nullable();
            $table->string('construction_year')->nullable();
            $table->string('construction_year_heating')->nullable();

            $table->string('ventilation')->nullable();
            $table->string('cellar')->nullable();

            $table->string('renewables')->nullable();
            $table->string('renewables_reason')->nullable();
            $table->string('cooling')->nullable();
            $table->string('cooling_count')->nullable();
            $table->dateTime('cooling_service')->nullable();

            $table->integer('vacancy_percentage')->nullable();

            $table->json('suggestion_check')->nullable();

            $table->decimal('price', 10)->default(79.90);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('verbrauchsausweise');
    }
};
