<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Set any invalid roles to 'user' before changing column type
        DB::table('users')->whereNotIn('role', ['user', 'superadmin'])->update(['role' => 'user']);

        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['user', 'superadmin'])->default('user')->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('user')->change();
        });
    }
};
