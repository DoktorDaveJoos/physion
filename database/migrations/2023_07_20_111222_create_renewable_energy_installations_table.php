<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('renewable_energy_installations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('bdrf_id');
            $table->foreign('bdrf_id')->references('id')->on('bdrfs')->cascadeOnDelete();

            $table->string('type');
            $table->decimal('area', 10);

            $table->boolean('electricity');
            $table->boolean('water');
            $table->boolean('heating');

            $table->integer('construction_year');
            $table->text('comment')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('renewable_energy_installations');
    }
};
