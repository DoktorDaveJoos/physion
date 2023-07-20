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
        Schema::create('heating_systems', function (Blueprint $table) {
            $table->id();

            $table->foreignId('bdrf_id');
            $table->foreign('bdrf_id')->references('id')->on('bdrfs')->cascadeOnDelete();

            $table->string('type');
            $table->string('system');
            $table->boolean('water_included');
            $table->integer('construction_year');
            $table->boolean('is_main')->default(false);
            $table->text('comment')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('heating_systems');
    }
};
