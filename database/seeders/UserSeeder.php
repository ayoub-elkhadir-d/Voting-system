<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name' => 'Admin',   'email' => 'admin@vote.test',   'password' => Hash::make('password')],
            ['name' => 'Alice',   'email' => 'alice@vote.test',   'password' => Hash::make('password')],
            ['name' => 'Bob',     'email' => 'bob@vote.test',     'password' => Hash::make('password')],
            ['name' => 'Carol',   'email' => 'carol@vote.test',   'password' => Hash::make('password')],
            ['name' => 'David',   'email' => 'david@vote.test',   'password' => Hash::make('password')],
            ['name' => 'Emma',    'email' => 'emma@vote.test',    'password' => Hash::make('password')],
            ['name' => 'Frank',   'email' => 'frank@vote.test',   'password' => Hash::make('password')],
            ['name' => 'Grace',   'email' => 'grace@vote.test',   'password' => Hash::make('password')],
            ['name' => 'Henry',   'email' => 'henry@vote.test',   'password' => Hash::make('password')],
            ['name' => 'Isla',    'email' => 'isla@vote.test',    'password' => Hash::make('password')],
            ['name' => 'Jack',    'email' => 'jack@vote.test',    'password' => Hash::make('password')],
            ['name' => 'Karen',   'email' => 'karen@vote.test',   'password' => Hash::make('password')],
            ['name' => 'Leo',     'email' => 'leo@vote.test',     'password' => Hash::make('password')],
            ['name' => 'Mia',     'email' => 'mia@vote.test',     'password' => Hash::make('password')],
            ['name' => 'Nathan',  'email' => 'nathan@vote.test',  'password' => Hash::make('password')],
            ['name' => 'Olivia',  'email' => 'olivia@vote.test',  'password' => Hash::make('password')],
            ['name' => 'Paul',    'email' => 'paul@vote.test',    'password' => Hash::make('password')],
            ['name' => 'Quinn',   'email' => 'quinn@vote.test',   'password' => Hash::make('password')],
            ['name' => 'Rachel',  'email' => 'rachel@vote.test',  'password' => Hash::make('password')],
            ['name' => 'Sam',     'email' => 'sam@vote.test',     'password' => Hash::make('password')],
            ['name' => 'Tina',    'email' => 'tina@vote.test',    'password' => Hash::make('password')],
            ['name' => 'Uma',     'email' => 'uma@vote.test',     'password' => Hash::make('password')],
            ['name' => 'Victor',  'email' => 'victor@vote.test',  'password' => Hash::make('password')],
            ['name' => 'Wendy',   'email' => 'wendy@vote.test',   'password' => Hash::make('password')],
            ['name' => 'Xander',  'email' => 'xander@vote.test',  'password' => Hash::make('password')],
        ];

        foreach ($users as $user) {
            User::firstOrCreate(['email' => $user['email']], $user);
        }
    }
}
