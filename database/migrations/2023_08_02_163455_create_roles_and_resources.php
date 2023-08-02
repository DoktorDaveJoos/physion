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
        Schema::create('roles', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('description')->nullable();

            $table->timestamps();
        });

        Schema::create('resources', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('display_name');
            $table->string('description')->nullable();

            $table->timestamps();
        });

        Schema::create('user_has_roles', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('role_id')->constrained('roles');

            $table->timestamps();
        });

        Schema::create('role_has_resources', function (Blueprint $table) {
            $table->id();

            $table->foreignId('role_id')->constrained('roles');
            $table->foreignId('resource_id')->constrained('resources');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_has_resources');
        Schema::dropIfExists('user_has_roles');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('resources');
    }
};
