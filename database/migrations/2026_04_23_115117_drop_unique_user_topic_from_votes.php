<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Add a plain index on user_id so the FK constraint stays satisfied
        DB::statement('ALTER TABLE votes ADD INDEX votes_user_id_index (user_id)');

        // Now we can safely drop the unique index
        DB::statement('ALTER TABLE votes DROP INDEX votes_user_id_topic_id_unique');

        // Add new unique: one vote per user per choice per topic
        DB::statement('ALTER TABLE votes ADD UNIQUE KEY votes_user_topic_choice_unique (user_id, topic_id, choix_id)');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE votes DROP INDEX votes_user_topic_choice_unique');
        DB::statement('ALTER TABLE votes ADD UNIQUE KEY votes_user_id_topic_id_unique (user_id, topic_id)');
        DB::statement('ALTER TABLE votes DROP INDEX votes_user_id_index');
    }
};
