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
        Schema::table('customers', function(Blueprint $table) {
            $table->string('title')->after('stripe_customer_id')->nullable();
            $table->string('type')->after('id')->nullable();
        });

        Schema::table('buildings', function(Blueprint $table) {
           $table->date('bauantrag_date')->after('status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function(Blueprint $table) {
            $table->dropColumn('title');
            $table->dropColumn('type');
        });

        Schema::table('buildings', function(Blueprint $table) {
            $table->dropColumn('bauantrag_date');
        });
    }
};
