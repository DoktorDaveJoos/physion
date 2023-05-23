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
    public function up(): void
    {
        Schema::create('bdrfs', function (Blueprint $table) {
            $table->id();

            $table->string('reason');
            $table->string('street_address');
            $table->string('zip');
            $table->string('city');

            $table->string('place_id')->nullable();

            $table->string('type');
            $table->string('additional_type');

            $table->integer('floor_area')->nullable();
            $table->integer('housing_units')->nullable();
            $table->string('construction_year')->nullable();
            $table->string('construction_year_heating')->nullable();

            $table->string('ventilation')->nullable();
            $table->string('cellar')->nullable();

            $table->string('cooling')->nullable();
            $table->string('cooling_count')->nullable();
            $table->dateTime('cooling_service')->nullable();

            $table->decimal('side_a', 10)->nullable();
            $table->decimal('side_b', 10)->nullable();

            $table->enum('maps', ['initial', 'agreed', 'denied'])->default('initial');
            $table->string('orientation')->nullable();

            $table->json('suggestion_check')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('bdrfs');
    }
};
