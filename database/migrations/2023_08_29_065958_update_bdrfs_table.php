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
        Schema::table('bdrfs', function (Blueprint $table) {
            $table->string('picture_path')->nullable()->after('suggestion_check');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bdrfs', function (Blueprint $table) {
            $table->dropColumn('picture_path');
        });
    }
};
