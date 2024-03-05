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
        Schema::create('consumptions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('building_id')->nullable()->constrained()->onDelete('cascade');

            $table->string('energy_source');
            $table->boolean('water_included');
            $table->date('start');
            $table->date('end');
            $table->integer('period');
            $table->decimal('consumption', 10);
            $table->integer('vacancy')->nullable();

            $table->text('comment')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consumptions');
    }
};
