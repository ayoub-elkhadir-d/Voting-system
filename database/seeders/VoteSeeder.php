<?php

namespace Database\Seeders;

use App\Models\choix;
use App\Models\membership;
use App\Models\Room;
use App\Models\Topic;
use App\Models\Vote;
use Illuminate\Database\Seeder;

class VoteSeeder extends Seeder
{
    public function run(): void
    {
        // Topics to mark as completed and seed votes for
        // [room_code => [topic_name, ...]]
        $completedTopics = [
            '100001' => [
                'Best City for Next Meetup',
                'Preferred Event Format',
                'Favorite Programming Language',
                'Best Learning Platform',
            ],
            '100002' => [
                'Sprint Goal Priority',
                'Story Point Scale',
                'Daily Standup Time',
            ],
            '200001' => [
                'Best Frontend Framework',
                'Best Backend Framework',
                'Preferred Database',
                'Container Technology',
            ],
            '200002' => [
                'Color Palette Selection',
                'Typography Choice',
                'Layout Style',
            ],
            '300001' => [
                'Most Requested Feature',
                'Biggest Pain Point',
                'Pricing Model Preference',
            ],
            '300002' => [
                'Q3 Budget Allocation',
                'Infrastructure Spend Limit',
            ],
            '400001' => [
                'Event Date',
                'Event Venue Type',
                'Event Theme',
                'Budget Range',
            ],
            '400002' => [
                'Interview Process Format',
                'Technical Test Difficulty',
            ],
            '500001' => [
                'Most Impactful Tech Trend',
                'AI Tool of the Year',
                'Remote Work Tool',
            ],
            '500002' => [
                'Next Major Version Theme',
                'Performance Milestone Target',
                'Open Source Strategy',
            ],
        ];

        foreach ($completedTopics as $roomCode => $topicNames) {
            $room = Room::where('code', $roomCode)->first();
            if (!$room) continue;

            // Get accepted members for this room
            $members = membership::where('room_id', $room->id)
                ->where('status', 'accepted')
                ->get();

            foreach ($topicNames as $topicName) {
                $topic = Topic::where('name', $topicName)
                    ->where('room_id', $room->id)
                    ->first();

                if (!$topic) continue;

                // Mark topic as completed
                $topic->status     = 'completed';
                $topic->started_at = now()->subMinutes(rand(10, 120));
                $topic->save();

                $choices = choix::where('topic_id', $topic->id)->get();
                if ($choices->isEmpty()) continue;

                // Each accepted member votes
                foreach ($members as $member) {
                    $userId = $member->user_id;

                    $alreadyVoted = Vote::where('user_id', $userId)
                        ->where('topic_id', $topic->id)
                        ->exists();

                    if ($alreadyVoted) continue;

                    $votesToCast = min($topic->max_choices, $choices->count());
                    $picked = $choices->shuffle()->take($votesToCast);

                    foreach ($picked as $choice) {
                        Vote::firstOrCreate([
                            'user_id'  => $userId,
                            'topic_id' => $topic->id,
                            'choix_id' => $choice->id,
                            'room_id'  => $room->id,
                        ]);
                    }
                }
            }
        }
    }
}
