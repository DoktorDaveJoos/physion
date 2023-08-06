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

        Schema::create('resources', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('display_name');
            $table->string('description')->nullable();

            $table->timestamps();
        });

        Schema::create('team_has_resources', function (Blueprint $table) {
            $table->id();

            $table->foreignId('team_id')->constrained('teams');
            $table->foreignId('resource_id')->constrained('resources');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_has_resources');
        Schema::dropIfExists('resources');
    }
};
