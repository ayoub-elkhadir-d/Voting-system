<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Step 1: expand enum to include both old and new values
        DB::statement("ALTER TABLE topics MODIFY vote_methode ENUM('custom','scale','fibonacci','percentage','countries','select_one','select_multiple') NOT NULL DEFAULT 'select_one'");

        // Step 2: migrate all existing rows to select_one
        DB::statement("UPDATE topics SET vote_methode = 'select_one'");

        // Step 3: shrink enum to only the new values
        DB::statement("ALTER TABLE topics MODIFY vote_methode ENUM('select_one','select_multiple') NOT NULL DEFAULT 'select_one'");

        // Step 4: add max_choices column
        DB::statement("ALTER TABLE topics ADD COLUMN max_choices TINYINT UNSIGNED NOT NULL DEFAULT 1 AFTER vote_methode");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE topics DROP COLUMN max_choices");
        DB::statement("ALTER TABLE topics MODIFY vote_methode ENUM('custom','scale','fibonacci','percentage','countries') NOT NULL");
    }
};
