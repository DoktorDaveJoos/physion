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
        Schema::create('cellars', function (Blueprint $table) {
            $table->id();

            $table->foreignId('building_id')->constrained()->cascadeOnDelete();

            $table->decimal('u_value', 10)->nullable();
            $table->string('type');

            $table->integer('ceiling')->nullable();
            $table->decimal('height', 10)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cellars');
    }
};
