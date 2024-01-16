<?php

use App\Models\Customer;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();

            $table->foreignIdFor(Customer::class)->constrained();

            $table->enum('status', ['created', 'finalized', 'open', 'shipped', 'in_clarification'])
                ->default('created');

            $table->integer('certificate_id');
            $table->string('certificate_type');

            $table->json('meta')->nullable();

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