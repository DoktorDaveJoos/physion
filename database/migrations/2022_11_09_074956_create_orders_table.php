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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('street-address');
            $table->string('zip');
            $table->string('city');
            $table->string('construction-year');
            $table->string('construction-year-heating');
            $table->string('living-space');
            $table->string('housing-units');
            $table->string('building-type');
            $table->string('ventilation');
            $table->string('renewables');
            $table->string('reason');
            $table->string('date-range-0-start');
            $table->string('date-range-0-end');
            $table->string('date-range-0-consumption');
            $table->string('date-range-1-start')->nullable();
            $table->string('date-range-1-end')->nullable();
            $table->string('date-range-1-consumption')->nullable();
            $table->string('date-range-2-start')->nullable();
            $table->string('date-range-2-end')->nullable();
            $table->string('date-range-2-consumption')->nullable();
            $table->string('vacancy-percentage')->nullable();
            $table->string('vacancy-range-0-start')->nullable();
            $table->string('vacancy-range-0-end')->nullable();
            $table->string('vacancy-range-1-start')->nullable();
            $table->string('vacancy-range-1-end')->nullable();
            $table->string('vacancy-range-2-start')->nullable();
            $table->string('vacancy-range-2-end')->nullable();
            $table->string('cooling')->nullable();
            $table->string('hot-water')->nullable();
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
