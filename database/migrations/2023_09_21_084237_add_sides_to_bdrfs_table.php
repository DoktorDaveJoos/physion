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
            $table->enum('layout', ['rectangle', 'l', 't'])->default('rectangle')->after('cooling_service');
            $table->decimal('side_d', 10)->nullable()->after('side_b');
            $table->decimal('side_c', 10)->nullable()->after('side_b');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bdrfs', function (Blueprint $table) {
            $table->dropColumn('layout');
            $table->dropColumn('side_d');
            $table->dropColumn('side_c');
        });
    }
};
