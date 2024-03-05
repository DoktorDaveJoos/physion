<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('credits', function (Blueprint $table) {
            $table->id();

            $table->string('key');
            $table->string('name');

            $table->decimal('default_amount', 10)->nullable();
            $table->decimal('default_grant', 10)->nullable();
            $table->decimal('default_gnq_extra_amount', 10)->nullable();
            $table->decimal('default_lifecycle_extra_amount', 10)->nullable();

            $table->string('link');

            $table->boolean('respects_housing_units')->default(false);
            $table->boolean('respects_gnq')->default(false);
            $table->boolean('respects_lifecycle')->default(false);

            $table->string('min_target_state')->nullable();

            $table->date('valid_until')->nullable();
            $table->date('valid_from');

            $table->timestamps();
        });

        Schema::create('credit_conditions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('credit_id')->constrained()->cascadeOnDelete();

            $table->decimal('interest', 10);
            $table->integer('interest_rate_fixation');

            $table->integer('duration_from');
            $table->integer('duration_to')->nullable();

            $table->integer('waiting_period_from');
            $table->integer('waiting_period_to')->nullable();

            $table->timestamps();
        });

        Schema::create('credit_amount_conditions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('credit_id')->constrained()->cascadeOnDelete();

            $table->json('condition');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credit_amount_conditions');
        Schema::dropIfExists('credit_amount_conditions');
        Schema::dropIfExists('credits');
    }
};
