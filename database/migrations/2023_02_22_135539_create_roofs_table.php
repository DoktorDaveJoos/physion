<?php

use App\Models\Bdrf;
use App\Models\Roof;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('roofs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('bdrf_id');
            $table->foreign('bdrf_id')->references('id')->on('bdrfs')->cascadeOnDelete();

            $table->decimal('u_value', 10)->nullable();
            $table->boolean('heated');

            $table->string('roof_shape');
            $table->string('construction');

            $table->integer('pitch')->nullable();
            $table->integer('knee_wall')->nullable();

            $table->integer('ceiling')->nullable();

            $table->timestamps();
        });

        Schema::create('insulations', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('insulationable_id');
            $table->string('insulationable_type');

            $table->string('type');
            $table->integer('thickness');

            $table->timestamps();
        });

        Schema::create('windows', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('windowable_id');
            $table->string('windowable_type');

            $table->enum('type', ['fenster', 'dachfenster']);
            $table->integer('count');
            $table->string('glazing');
            $table->integer('height');
            $table->integer('width');

            $table->timestamps();
        });

        Schema::create('dormers', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Roof::class)->constrained()->cascadeOnDelete();

            $table->integer('count');
            $table->string('form');
            $table->integer('height');
            $table->integer('width');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('insulations');
        Schema::dropIfExists('windows');
        Schema::dropIfExists('dormers');
        Schema::dropIfExists('roofs');
    }
};
