<?php

use App\Models\Bdrf;
use App\Models\EnergyCertificate;
use App\Models\Vrbr;
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
        Schema::create('energy_certificates', function (Blueprint $table) {
            $table->id();

            $table->foreignId('building_id')->constrained()->cascadeOnDelete();
            $table->foreignId('attachment_id')->nullable()->constrained();

            $table->enum('type', ['vrbr', 'bdrf']);
            $table->enum('status', ['open', 'done', 'in_clarification', 'deleted']);

            $table->string('rating')->nullable();

            $table->string('reason');
            $table->json('suggestion_check');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('energy_certificates');

    }
};
