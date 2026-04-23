<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE topics MODIFY vote_methode ENUM('custom','scale','fibonacci','percentage','countries')");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE topics MODIFY vote_methode ENUM('custom','scale','fibonacci','percentage')");
    }
};
