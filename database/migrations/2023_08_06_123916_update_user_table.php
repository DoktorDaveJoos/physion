<?php

use App\Models\User;
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
        Schema::table('users', function (Blueprint $table) {
            $table->string('last_name')->after('name')->nullable();
            $table->string('first_name')->after('name')->nullable();
        });

        $users = User::all();
        foreach($users as $user) {
            $name = explode(' ', $user->name);
            $user->first_name = $name[0] ?? null;
            $user->last_name = $name[1] ?? null;
            $user->save();
        }

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['name']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name')->after('id');
        });

        $users = User::all();
        foreach($users as $user) {
            $user->name = $user->first_name . ' ' . $user->last_name;
            $user->save();
        }

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['first_name', 'last_name']);
        });
    }
};
