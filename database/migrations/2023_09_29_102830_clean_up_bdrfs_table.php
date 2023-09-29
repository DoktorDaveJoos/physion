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
        Schema::table('bdrfs', function (Blueprint $table) {
            $table->dropColumn('street_address');
            $table->dropColumn('zip');
            $table->dropColumn('city');
            $table->dropColumn('place_id');
            $table->dropColumn('type');
            $table->dropColumn('additional_type');
            $table->dropColumn('floor_area');
            $table->dropColumn('floors');
            $table->dropColumn('housing_units');
            $table->dropColumn('construction_year');
            $table->dropColumn('construction_year_heating');
            $table->dropColumn('ventilation');
            $table->dropColumn('cooling');
            $table->dropColumn('cooling_count');
            $table->dropColumn('cooling_service');
            $table->dropColumn('layout');
            $table->dropColumn('side_a');
            $table->dropColumn('side_b');
            $table->dropColumn('side_c');
            $table->dropColumn('side_d');
            $table->dropColumn('maps');
            $table->dropColumn('orientation');
            $table->dropColumn('picture_path');

            $table->string('file')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // one way
    }
};
