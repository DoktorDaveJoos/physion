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
        Schema::create('bzas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('building_id')->constrained();
            $table->foreignId('product_id')->constrained();
            $table->foreignId('customer_id')->constrained();

            $table->enum('status', ['created', 'open', 'finished', 'cancelled'])->default('created');

            $table->string('target')->nullable();
            $table->string('bza_number')->nullable();

            $table->string('bza_path')->nullable();
            $table->string('power_of_attorney_path')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bzas');
    }
};
