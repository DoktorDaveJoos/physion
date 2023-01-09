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
        Schema::create('consumption_periods', function (Blueprint $table) {
            $table->id();

            $table->foreignId('energy_source_id')->constrained()->cascadeOnDelete();

            $table->string('start');
            $table->string('end');
            $table->string('consumption');
            $table->string('water')->nullable();

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
        Schema::dropIfExists('consumption_periods');
    }
};
