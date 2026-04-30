<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $rooms = [
            // admin — 2 rooms
            ['name' => 'Community Poll',    'code' => '100001', 'description' => 'Open community voting.',      'member_limit' => 50, 'visibility' => 'public',  'status' => 'pending', 'owner' => 'admin@vote.test'],
            ['name' => 'Sprint Planning',   'code' => '100002', 'description' => 'Team sprint priorities.',     'member_limit' => 10, 'visibility' => 'private', 'status' => 'pending', 'owner' => 'admin@vote.test'],
            // alice — 2 rooms
            ['name' => 'Tech Survey',       'code' => '200001', 'description' => 'Technology preferences.',     'member_limit' => 40, 'visibility' => 'public',  'status' => 'pending', 'owner' => 'alice@vote.test'],
            ['name' => 'Design Review',     'code' => '200002', 'description' => 'Internal design decisions.',  'member_limit' => 10, 'visibility' => 'private', 'status' => 'pending', 'owner' => 'alice@vote.test'],
            // bob — 2 rooms
            ['name' => 'Product Feedback',  'code' => '300001', 'description' => 'Gather product feedback.',    'member_limit' => 50, 'visibility' => 'public',  'status' => 'pending', 'owner' => 'bob@vote.test'],
            ['name' => 'Budget Allocation', 'code' => '300002', 'description' => 'Finance team budget votes.',  'member_limit' => 8,  'visibility' => 'private', 'status' => 'pending', 'owner' => 'bob@vote.test'],
            // carol — 2 rooms
            ['name' => 'Event Planning',    'code' => '400001', 'description' => 'Vote on event details.',      'member_limit' => 30, 'visibility' => 'public',  'status' => 'pending', 'owner' => 'carol@vote.test'],
            ['name' => 'Hiring Decision',   'code' => '400002', 'description' => 'HR candidate selection.',     'member_limit' => 5,  'visibility' => 'private', 'status' => 'pending', 'owner' => 'carol@vote.test'],
            // david — 2 rooms
            ['name' => 'Open Q&A Vote',     'code' => '500001', 'description' => 'Public Q&A voting session.',  'member_limit' => 60, 'visibility' => 'public',  'status' => 'pending', 'owner' => 'david@vote.test'],
            ['name' => 'Roadmap Planning',  'code' => '500002', 'description' => 'Product roadmap priorities.', 'member_limit' => 12, 'visibility' => 'private', 'status' => 'pending', 'owner' => 'david@vote.test'],
        ];

        foreach ($rooms as $room) {
            $owner = User::where('email', $room['owner'])->first();
            Room::firstOrCreate(
                ['code' => $room['code']],
                [
                    'name'         => $room['name'],
                    'description'  => $room['description'],
                    'member_limit' => $room['member_limit'],
                    'visibility'   => $room['visibility'],
                    'status'       => $room['status'],
                    'user_id'      => $owner->id,
                ]
            );
        }
    }
}
