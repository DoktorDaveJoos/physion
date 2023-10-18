<?php

use App\Models\Cellar;
use App\Models\Heating;
use App\Models\Renewable;
use App\Models\Roof;
use App\Models\Wall;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Walls
        Schema::table('walls', function (Blueprint $table) {
            $table->foreignId('building_id')->after('id')->nullable();
            $table->foreign('building_id')->references('id')->on('buildings')->cascadeOnDelete();
        });

        Wall::all()->each(function ($wall) {
            $wall->building_id = $wall->bedarfsausweis->building_id;
            $wall->save();
        });

        Schema::table('walls', function (Blueprint $table) {
            $table->dropForeign('walls_bdrf_id_foreign');
            $table->dropColumn('bdrf_id');
        });

        // Roofs
        Schema::table('roofs', function (Blueprint $table) {
            $table->foreignId('building_id')->after('id')->nullable();
            $table->foreign('building_id')->references('id')->on('buildings')->cascadeOnDelete();
        });

        Roof::all()->each(function ($roof) {
            $roof->building_id = $roof->bedarfsausweis->building_id;
            $roof->save();
        });

        Schema::table('roofs', function (Blueprint $table) {
            $table->dropForeign('roofs_bdrf_id_foreign');
            $table->dropColumn('bdrf_id');
        });

        // RenewableEnergyInstallations
        Schema::table('renewable_energy_installations', function (Blueprint $table) {
            $table->foreignId('building_id')->after('id')->nullable();
            $table->foreign('building_id')->references('id')->on('buildings')->cascadeOnDelete();
        });

        Renewable::all()->each(function ($renewableEnergyInstallation) {
            $renewableEnergyInstallation->building_id = $renewableEnergyInstallation->bedarfsausweis->building_id;
            $renewableEnergyInstallation->save();
        });

        Schema::table('renewable_energy_installations', function (Blueprint $table) {
            $table->dropForeign('renewable_energy_installations_bdrf_id_foreign');
            $table->dropColumn('bdrf_id');
        });

        // Cellars
        Schema::table('cellars', function (Blueprint $table) {
            $table->foreignId('building_id')->after('id')->nullable();
            $table->foreign('building_id')->references('id')->on('buildings')->cascadeOnDelete();
        });

        Cellar::all()->each(function ($cellar) {
            $cellar->building_id = $cellar->bedarfsausweis->building_id;
            $cellar->save();
        });

        Schema::table('cellars', function (Blueprint $table) {
            $table->dropForeign('cellars_bdrf_id_foreign');
            $table->dropColumn('bdrf_id');
        });

        // HeatingSystems
        Schema::table('heating_systems', function (Blueprint $table) {
            $table->foreignId('building_id')->after('id')->nullable();
            $table->foreign('building_id')->references('id')->on('buildings')->cascadeOnDelete();
        });

        Heating::all()->each(function ($heatingSystem) {
            $heatingSystem->building_id = $heatingSystem->bedarfsausweis->building_id;
            $heatingSystem->save();
        });

        Schema::table('heating_systems', function (Blueprint $table) {
            $table->dropForeign('heating_systems_bdrf_id_foreign');
            $table->dropColumn('bdrf_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Walls
        Schema::table('walls', function (Blueprint $table) {
            $table->foreignId('bdrf_id')->after('id')->nullable();
            $table->foreign('bdrf_id')->references('id')->on('bdrfs')->cascadeOnDelete();
        });

        Wall::all()->each(function ($wall) {
            $wall->bdrf_id = $wall->building->bdrf->id;
            $wall->save();
        });

        Schema::table('walls', function (Blueprint $table) {
            $table->dropForeign('walls_building_id_foreign');
            $table->dropColumn('building_id');
        });

        // Roofs
        Schema::table('roofs', function (Blueprint $table) {
            $table->foreignId('bdrf_id')->after('id')->nullable();
            $table->foreign('bdrf_id')->references('id')->on('bdrfs')->cascadeOnDelete();
        });

        Roof::all()->each(function ($roof) {
            $roof->bdrf_id = $roof->building->id;
            $roof->save();
        });

        Schema::table('roofs', function (Blueprint $table) {
            $table->dropForeign('roofs_building_id_foreign');
            $table->dropColumn('building_id');
        });

        // RenewableEnergyInstallations
        Schema::table('renewable_energy_installations', function (Blueprint $table) {
            $table->foreignId('bdrf_id')->after('id')->nullable();
            $table->foreign('bdrf_id')->references('id')->on('bdrfs')->cascadeOnDelete();
        });

        Renewable::all()->each(function ($renewableEnergyInstallation) {
            $renewableEnergyInstallation->bdrf_id = $renewableEnergyInstallation->building->id;
            $renewableEnergyInstallation->save();
        });

        Schema::table('renewable_energy_installations', function (Blueprint $table) {
            $table->dropForeign('renewable_energy_installations_building_id_foreign');
            $table->dropColumn('building_id');
        });

        // Cellars
        Schema::table('cellars', function (Blueprint $table) {
            $table->foreignId('bdrf_id')->after('id')->nullable();
            $table->foreign('bdrf_id')->references('id')->on('bdrfs')->cascadeOnDelete();
        });

        Cellar::all()->each(function ($cellar) {
            $cellar->bdrf_id = $cellar->building->id;
            $cellar->save();
        });

        Schema::table('cellars', function (Blueprint $table) {
            $table->dropForeign('cellars_building_id_foreign');
            $table->dropColumn('building_id');
        });

        // HeatingSystems
        Schema::table('heating_systems', function (Blueprint $table) {
            $table->foreignId('bdrf_id')->after('id')->nullable();
            $table->foreign('bdrf_id')->references('id')->on('bdrfs')->cascadeOnDelete();
        });

        Heating::all()->each(function ($heatingSystem) {
            $heatingSystem->bdrf_id = $heatingSystem->building->id;
            $heatingSystem->save();
        });

        Schema::table('heating_systems', function (Blueprint $table) {
            $table->dropForeign('heating_systems_building_id_foreign');
            $table->dropColumn('building_id');
        });
    }
};
