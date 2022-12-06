<?php

use App\Models\ConsumptionCertificate;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('consumptions', function (Blueprint $table) {
            $table->foreign('consumption_certificate_id')->references('id')->on('consumption_certificates');
        });

        Schema::table('vacancies', function (Blueprint $table) {
            $table->foreign('consumption_certificate_id')->references('id')->on('consumption_certificates');
        });

        Schema::table('additionals', function (Blueprint $table) {
            $table->foreign('consumption_certificate_id')->references('id')->on('consumption_certificates');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
