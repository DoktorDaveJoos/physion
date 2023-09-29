<?php

use App\Models\Attachment;
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
        Schema::table('attachments', function (Blueprint $table) {
            $table->foreignId('building_id')->nullable()->constrained()->onDelete('cascade');
        });

        Attachment::all()->each(function ($attachment) {
            $attachment->building_id = $attachment->order->certificate->building_id;
            $attachment->save();
        });

        Schema::table('attachments', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
            $table->dropColumn('order_id');
        });

        DB::statement("ALTER TABLE attachments MODIFY COLUMN type ENUM('certificate', 'guide', 'baugesuch', 'grundriss', 'misc')");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attachments', function (Blueprint $table) {
            $table->foreignId('order_id')->nullable()->constrained()->onDelete('cascade');
        });

        Attachment::all()->each(function ($attachment) {
            $attachment->order_id = 1;
            $attachment->save();
        });

        Schema::table('attachments', function (Blueprint $table) {
            $table->dropForeign(['building_id']);
            $table->dropColumn('building_id');
        });
    }
};
