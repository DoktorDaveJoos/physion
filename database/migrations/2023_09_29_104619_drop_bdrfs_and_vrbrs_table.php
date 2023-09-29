<?php

use App\Models\Bdrf;
use App\Models\EnergyCertificate;
use App\Models\Vacancy;
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
        Bdrf::all()->each(function ($bdrf) {
            EnergyCertificate::create([
                'building_id' => $bdrf->building_id,
                'type' => 'bdrf',
                'status' => 'open',
                'reason' => $bdrf->reason,
                'suggestion_check' => json_encode($bdrf->suggestion_check),
                'file' => null,
                'created_at' => $bdrf->created_at,
                'updated_at' => $bdrf->updated_at,
            ]);
        });

        Vrbr::all()->each(function ($vrbr) {
            EnergyCertificate::create([
                'building_id' => $vrbr->building_id,
                'type' => 'vrbr',
                'status' => 'open',
                'reason' => $vrbr->reason,
                'suggestion_check' => json_encode($vrbr->suggestion_check),
                'file' => null,
                'created_at' => $vrbr->created_at,
                'updated_at' => $vrbr->updated_at,
            ]);
        });

        Schema::dropIfExists('bdrfs');

        Schema::dropIfExists('vacancies');
        Schema::dropIfExists('consumption_periods');
        Schema::dropIfExists('energy_sources');
        Schema::dropIfExists('vrbrs');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};
