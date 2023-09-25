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
        Schema::table('cellars', function (Blueprint $table) {
            $table->decimal('height', 10)->nullable()->after('ceiling');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cellars', function (Blueprint $table) {
            $table->dropColumn('height');
        });
    }
};
