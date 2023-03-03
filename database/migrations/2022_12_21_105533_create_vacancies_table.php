<?php

use App\Models\Vrbr;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('vacancies', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Vrbr::class)->constrained()->cascadeOnDelete();

            $table->dateTime('start')->nullable();
            $table->dateTime('end')->nullable();

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
        Schema::dropIfExists('vacancies');
    }
};
