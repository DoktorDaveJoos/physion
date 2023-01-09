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
        Schema::create('energy_sources', function (Blueprint $table) {
            $table->id();

            $table->foreignId('verbrauchsausweis_id');
            $table->foreign('verbrauchsausweis_id')->references('id')->on('verbrauchsausweise');

            $table->string('source');
            $table->string('water');
            $table->boolean('water_enabled');
            $table->string('main')->default('0');

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
        Schema::dropIfExists('energy_sources');
    }
};
