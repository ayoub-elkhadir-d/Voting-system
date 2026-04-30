<?php

namespace Database\Seeders;

use App\Models\membership;
use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Seeder;

class MembershipSeeder extends Seeder
{
    public function run(): void
    {
        // Each entry: [room_code, member_email, username, role, status]
        $memberships = [
            // Community Poll (public) — alice, bob, carol join
            ['100001', 'alice@vote.test', 'Alice',   'user', 'accepted'],
            ['100001', 'bob@vote.test',   'Bob',     'user', 'accepted'],
            ['100001', 'carol@vote.test', 'Carol',   'user', 'accepted'],

            // Sprint Planning (private) — alice accepted, bob pending
            ['100002', 'alice@vote.test', 'Alice',   'user', 'accepted'],
            ['100002', 'bob@vote.test',   'Bob',     'user', 'pending'],

            // Tech Survey (public) — admin, bob, david join
            ['200001', 'admin@vote.test', 'Admin',   'user', 'accepted'],
            ['200001', 'bob@vote.test',   'Bob',     'user', 'accepted'],
            ['200001', 'david@vote.test', 'David',   'user', 'accepted'],

            // Design Review (private) — admin accepted, carol pending
            ['200002', 'admin@vote.test', 'Admin',   'user', 'accepted'],
            ['200002', 'carol@vote.test', 'Carol',   'user', 'pending'],

            // Product Feedback (public) — alice, carol, david join
            ['300001', 'alice@vote.test', 'Alice',   'user', 'accepted'],
            ['300001', 'carol@vote.test', 'Carol',   'user', 'accepted'],
            ['300001', 'david@vote.test', 'David',   'user', 'accepted'],

            // Budget Allocation (private) — alice accepted, david pending
            ['300002', 'alice@vote.test', 'Alice',   'user', 'accepted'],
            ['300002', 'david@vote.test', 'David',   'user', 'pending'],

            // Event Planning (public) — admin, bob, david join
            ['400001', 'admin@vote.test', 'Admin',   'user', 'accepted'],
            ['400001', 'bob@vote.test',   'Bob',     'user', 'accepted'],
            ['400001', 'david@vote.test', 'David',   'user', 'accepted'],

            // Hiring Decision (private) — alice accepted, bob pending
            ['400002', 'alice@vote.test', 'Alice',   'user', 'accepted'],
            ['400002', 'bob@vote.test',   'Bob',     'user', 'pending'],

            // Open Q&A Vote (public) — alice, bob, carol join
            ['500001', 'alice@vote.test', 'Alice',   'user', 'accepted'],
            ['500001', 'bob@vote.test',   'Bob',     'user', 'accepted'],
            ['500001', 'carol@vote.test', 'Carol',   'user', 'accepted'],

            // Roadmap Planning (private) — alice accepted, carol pending
            ['500002', 'alice@vote.test', 'Alice',   'user', 'accepted'],
            ['500002', 'carol@vote.test', 'Carol',   'user', 'pending'],

            // ── 20 new users spread across rooms ──────────────────────────

            // Community Poll (public)
            ['100001', 'emma@vote.test',   'Emma',   'user', 'accepted'],
            ['100001', 'frank@vote.test',  'Frank',  'user', 'accepted'],
            ['100001', 'grace@vote.test',  'Grace',  'user', 'accepted'],
            ['100001', 'henry@vote.test',  'Henry',  'user', 'accepted'],
            ['100001', 'isla@vote.test',   'Isla',   'user', 'accepted'],

            // Sprint Planning (private)
            ['100002', 'jack@vote.test',   'Jack',   'user', 'accepted'],
            ['100002', 'karen@vote.test',  'Karen',  'user', 'accepted'],
            ['100002', 'leo@vote.test',    'Leo',    'user', 'pending'],

            // Tech Survey (public)
            ['200001', 'mia@vote.test',    'Mia',    'user', 'accepted'],
            ['200001', 'nathan@vote.test', 'Nathan', 'user', 'accepted'],
            ['200001', 'olivia@vote.test', 'Olivia', 'user', 'accepted'],
            ['200001', 'paul@vote.test',   'Paul',   'user', 'accepted'],

            // Design Review (private)
            ['200002', 'quinn@vote.test',  'Quinn',  'user', 'accepted'],
            ['200002', 'rachel@vote.test', 'Rachel', 'user', 'pending'],

            // Product Feedback (public)
            ['300001', 'sam@vote.test',    'Sam',    'user', 'accepted'],
            ['300001', 'tina@vote.test',   'Tina',   'user', 'accepted'],
            ['300001', 'uma@vote.test',    'Uma',    'user', 'accepted'],
            ['300001', 'victor@vote.test', 'Victor', 'user', 'accepted'],

            // Budget Allocation (private)
            ['300002', 'wendy@vote.test',  'Wendy',  'user', 'accepted'],
            ['300002', 'xander@vote.test', 'Xander', 'user', 'pending'],

            // Event Planning (public)
            ['400001', 'emma@vote.test',   'Emma',   'user', 'accepted'],
            ['400001', 'grace@vote.test',  'Grace',  'user', 'accepted'],
            ['400001', 'mia@vote.test',    'Mia',    'user', 'accepted'],
            ['400001', 'sam@vote.test',    'Sam',    'user', 'accepted'],
            ['400001', 'tina@vote.test',   'Tina',   'user', 'accepted'],

            // Hiring Decision (private)
            ['400002', 'frank@vote.test',  'Frank',  'user', 'accepted'],
            ['400002', 'henry@vote.test',  'Henry',  'user', 'accepted'],
            ['400002', 'jack@vote.test',   'Jack',   'user', 'pending'],

            // Open Q&A Vote (public)
            ['500001', 'nathan@vote.test', 'Nathan', 'user', 'accepted'],
            ['500001', 'olivia@vote.test', 'Olivia', 'user', 'accepted'],
            ['500001', 'paul@vote.test',   'Paul',   'user', 'accepted'],
            ['500001', 'quinn@vote.test',  'Quinn',  'user', 'accepted'],
            ['500001', 'victor@vote.test', 'Victor', 'user', 'accepted'],

            // Roadmap Planning (private)
            ['500002', 'rachel@vote.test', 'Rachel', 'user', 'accepted'],
            ['500002', 'wendy@vote.test',  'Wendy',  'user', 'accepted'],
            ['500002', 'xander@vote.test', 'Xander', 'user', 'pending'],
        ];

        foreach ($memberships as [$code, $email, $username, $role, $status]) {
            $room = Room::where('code', $code)->first();
            $user = User::where('email', $email)->first();

            if (!$room || !$user) {
                continue;
            }

            membership::firstOrCreate(
                ['room_id' => $room->id, 'user_id' => $user->id],
                ['username' => $username, 'role' => $role, 'status' => $status]
            );
        }
    }
}
