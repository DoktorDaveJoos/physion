<?php

use App\Models\Additional;
use App\Models\Consumption;
use App\Models\ConsumptionCertificate;
use App\Models\Order;
use App\Models\Vacancy;
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
    public function up()
    {
        Schema::table('consumptions', function(Blueprint $table) {
            $table->foreignIdFor(ConsumptionCertificate::class)->after('id');
        });
        Schema::table('additionals', function(Blueprint $table) {
            $table->foreignIdFor(ConsumptionCertificate::class)->after('id');
        });
        Schema::table('vacancies', function(Blueprint $table) {
            $table->foreignIdFor(ConsumptionCertificate::class)->after('id');
        });

        foreach(Consumption::all() as $consumption) {
            $consumption->consumption_certificate_id = $consumption->order_id;
            $consumption->save();
        }
        foreach(Additional::all() as $additional) {
            $additional->consumption_certificate_id = $additional->order_id;
            $additional->save();
        }
        foreach(Vacancy::all() as $vacancy) {
            $vacancy->consumption_certificate_id = $vacancy->order_id;
            $vacancy->save();
        }

        Schema::table('consumptions', function(Blueprint $table) {
            $table->dropForeignIdFor(Order::class);
            $table->dropColumn('order_id');
        });
        Schema::table('additionals', function(Blueprint $table) {
            $table->dropForeignIdFor(Order::class);
            $table->dropColumn('order_id');
        });
        Schema::table('vacancies', function(Blueprint $table) {
            $table->dropForeignIdFor(Order::class);
            $table->dropColumn('order_id');
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
