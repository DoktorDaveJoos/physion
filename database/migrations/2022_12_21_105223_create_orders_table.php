<?php

use App\Models\Customer;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->string('id')->unique()->primary();
            $table->foreignIdFor(Customer::class)->constrained();

            $table->enum('status', ['created', 'open', 'done', 'cancelled', 'in_clarification']);

            $table->boolean('paid')->default(false);

            $table->integer('product_id');
            $table->string('product_type');

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
        Schema::dropIfExists('orders');
    }
};
