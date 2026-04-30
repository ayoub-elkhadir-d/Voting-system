<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            RoomSeeder::class,
            TopicSeeder::class,
            ChoixSeeder::class,
            MembershipSeeder::class,
            VoteSeeder::class,
        ]);
    }
}
