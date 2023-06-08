<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->string('stripe_product_id')->nullable();

            $table->enum('type', ['certificate', 'guide', 'service']);

            $table->string('name');
            $table->string('short_name');
            $table->string('description');

            $table->decimal('price', 10);

            $table->string('image')->nullable();
            $table->string('image_alt')->nullable();

            $table->timestamps();
        });

        Schema::create('product_product', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_id')->constrained();
            $table->foreignId('related_product_id')->constrained('products');

            $table->timestamps();
        });

        Schema::create('order_product', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_id')->constrained();
            $table->foreignId('order_id')->constrained();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_product');
        Schema::dropIfExists('order_product');
        Schema::dropIfExists('products');
    }
};
