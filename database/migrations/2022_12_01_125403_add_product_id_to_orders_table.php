<?php

use App\Models\ConsumptionCertificate;
use App\Models\Order;
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
        Schema::table('orders', function (Blueprint $table) {
            $table->integer('product_id');
            $table->string('product_type');
        });

        foreach(ConsumptionCertificate::all() as $cCertificate) {
            $order = $cCertificate->order;

            $order->product_id = $cCertificate['id'];
            $order->product_type = ConsumptionCertificate::class;
            $order->save();
        }

        Schema::table('consumption_certificates', function(Blueprint $table) {
            $table->dropForeign('generals_order_id_foreign');
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
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
};
