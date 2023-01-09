<?php

use App\Models\Order;
use App\Models\Upsell;
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
        Schema::create('order_upsell', function (Blueprint $table) {
            $table->id();

            $table->string('order_id');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');

            $table->foreignIdFor(Upsell::class)->constrained();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_upsell');
    }
};
