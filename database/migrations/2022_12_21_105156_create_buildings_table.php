<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('buildings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->nullable()->constrained();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users');
            $table->enum('status', ['created', 'finished', 'locked'])->default('created');

            $table->boolean('new_building');

            $table->date('bauantrag_date')->nullable();
            $table->string('street');
            $table->string('house_number');
            $table->string('postal_code');
            $table->string('city');
            $table->string('state')->nullable();
            $table->string('country')->nullable()->default('Deutschland');
            $table->string('type');
            $table->string('additional_type')->nullable();
            $table->decimal('land_area', 10)->nullable();
            $table->decimal('floor_area', 10)->nullable();
            $table->integer('floors')->nullable();
            $table->integer('floor')->nullable();
            $table->integer('rooms')->nullable();
            $table->integer('housing_units')->nullable();
            $table->integer('construction_year')->nullable();
            $table->string('ventilation')->nullable();
            $table->string('cooling')->nullable();
            $table->integer('cooling_count')->nullable();
            $table->datetime('cooling_service')->nullable();
            $table->enum('layout', ['rectangle', 'l', 'u', 't', 'h'])->nullable();
            $table->decimal('side_a', 10)->nullable();
            $table->decimal('side_b', 10)->nullable();
            $table->decimal('side_c', 10)->nullable();
            $table->decimal('side_d', 10)->nullable();
            $table->decimal('side_e', 10)->nullable();
            $table->enum('maps', ['initial', 'agreed', 'denied'])->default('initial');
            $table->string('orientation')->nullable();
            $table->string('image')->nullable();
            $table->string('place_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('buildings');
    }
};
