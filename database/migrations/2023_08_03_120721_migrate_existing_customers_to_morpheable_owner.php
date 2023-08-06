<?php

use App\Models\Order;
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
        $orders = Order::all();

        foreach($orders as $order) {
            $order->owner_id = $order->customer_id;
            $order->owner_type = 'App\Models\Customer';
            $order->save();
        }

        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['customer_id']);
            $table->dropColumn(['customer_id']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('customer_id')->constrained('customers');
        });

        $orders = Order::all();
        foreach($orders as $order) {
            $order->customer_id = $order->owner_id;
            $order->save();
        }
    }
};
