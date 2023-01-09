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
        Schema::create('bedarfsausweise', function (Blueprint $table) {
            $table->id();

            $table->string('reason');
            $table->string('street_address');
            $table->string('zip');
            $table->string('city');

            $table->string('type');
            $table->string('additional_type');
            $table->integer('housing_units')->nullable();
            $table->string('construction_year')->nullable();

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
        Schema::dropIfExists('bedarfsausweise');
    }
};
