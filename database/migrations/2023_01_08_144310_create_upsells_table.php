<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('upsells', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->text('description');
            $table->decimal('price', 10);
            $table->boolean('recommended')->default(false);

            $table->timestamps();
        });

        DB::insert('INSERT INTO upsells (name, description, price, recommended, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)', [
            'Kostenlose Korrektur',
            'Vermeiden Sie überflüssige Kosten durch Fehler im Energieausweis mit unserem kostenlosen Korrektur-Service.',
            14.90,
            false,
            now(),
            now()
        ]);

        DB::insert('INSERT INTO upsells (name, description, price, recommended, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)', [
            'Erweiterte Überprüfung',
            'Steigern Sie Ihre Sicherheit und sparen Sie Geld mit unserer erweiterten Überprüfung durch einen Experten.',
            19.90,
            true,
            now(),
            now()
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('upsells');
    }
};
