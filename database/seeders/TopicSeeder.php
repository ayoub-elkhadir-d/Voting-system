<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Database\Seeder;

class TopicSeeder extends Seeder
{
    public function run(): void
    {
        // [room_code => [topics]]
        // Topic fillable: name, duration, room_id, user_id, vote_methode, max_choices
        $data = [
            '100001' => [
                ['name' => 'Best City for Next Meetup',     'duration' => '00:02:00', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Preferred Event Format',        'duration' => '00:02:00', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Favorite Programming Language', 'duration' => '00:02:00', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Best Learning Platform',        'duration' => '00:01:30', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Top Open Source Project',       'duration' => '00:02:00', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Preferred Communication Tool',  'duration' => '00:01:00', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Best Code Editor',              'duration' => '00:01:30', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Favorite Cloud Provider',       'duration' => '00:02:00', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Most Useful Community Resource','duration' => '00:01:30', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Next Community Challenge Topic','duration' => '00:02:00', 'vote_methode' => 'select_one',      'max_choices' => 1],
            ],
            '100002' => [
                ['name' => 'Sprint Goal Priority',          'duration' => '00:02:00', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Story Point Scale',             'duration' => '00:01:30', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Velocity Target',               'duration' => '00:01:30', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Tech Debt vs Features',         'duration' => '00:02:00', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Definition of Done',            'duration' => '00:02:00', 'vote_methode' => 'select_multiple', 'max_choices' => 3],
                ['name' => 'Retrospective Format',          'duration' => '00:01:00', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Daily Standup Time',            'duration' => '00:01:00', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Sprint Length',                 'duration' => '00:01:30', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Release Strategy',              'duration' => '00:02:00', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Code Freeze Policy',            'duration' => '00:01:30', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'On-Call Rotation',              'duration' => '00:01:00', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Pair Programming Frequency',    'duration' => '00:01:00', 'vote_methode' => 'select_one',      'max_choices' => 1],
            ],
            '200001' => [
                ['name' => 'Best Frontend Framework',       'duration' => '00:02:00', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Best Backend Framework',        'duration' => '00:02:00', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Preferred Database',            'duration' => '00:02:00', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Container Technology',          'duration' => '00:01:30', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'CI/CD Tool Preference',         'duration' => '00:01:30', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Testing Framework',             'duration' => '00:01:30', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'API Style Preference',          'duration' => '00:01:30', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Agile Methodology',             'duration' => '00:02:00', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Monitoring Tool',               'duration' => '00:01:30', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Version Control Workflow',      'duration' => '00:01:30', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Code Review Tool',              'duration' => '00:01:00', 'vote_methode' => 'select_one',      'max_choices' => 1],
            ],
            '200002' => [
                ['name' => 'Color Palette Selection',       'duration' => '00:02:00', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Typography Choice',             'duration' => '00:01:30', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Layout Style',                  'duration' => '00:02:00', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Icon Set Preference',           'duration' => '00:01:30', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Animation Level',               'duration' => '00:01:00', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Component Library',             'duration' => '00:02:00', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Dark Mode Priority',            'duration' => '00:01:00', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Accessibility Standard',        'duration' => '00:01:30', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Responsive Breakpoints',        'duration' => '00:01:30', 'vote_methode' => 'select_multiple', 'max_choices' => 2],
                ['name' => 'Design System Adoption',        'duration' => '00:02:00', 'vote_methode' => 'select_one',      'max_choices' => 1],
            ],
            '300001' => [
                ['name' => 'Most Requested Feature',        'duration' => '00:03:00', 'vote_methode' => 'select_multiple', 'max_choices' => 3],
                ['name' => 'Biggest Pain Point',            'duration' => '00:02:00', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'UI Improvement Priority',       'duration' => '00:02:00', 'vote_methode' => 'select_multiple', 'max_choices' => 2],
                ['name' => 'Mobile App Priority',           'duration' => '00:02:00', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Notification Preferences',      'duration' => '00:01:30', 'vote_methode' => 'select_multiple', 'max_choices' => 3],
                ['name' => 'Pricing Model Preference',      'duration' => '00:02:00', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Support Channel Preference',    'duration' => '00:01:30', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Integration Priority',          'duration' => '00:02:00', 'vote_methode' => 'select_multiple', 'max_choices' => 2],
                ['name' => 'Documentation Format',          'duration' => '00:01:00', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Release Cadence Preference',    'duration' => '00:01:30', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Performance vs Features',       'duration' => '00:01:30', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Beta Testing Interest',         'duration' => '00:01:00', 'vote_methode' => 'select_one',      'max_choices' => 1],
            ],
            '300002' => [
                ['name' => 'Q3 Budget Allocation',          'duration' => '00:03:00', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Infrastructure Spend Limit',    'duration' => '00:02:00', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Marketing Budget Share',        'duration' => '00:02:00', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Cost Cutting Area',             'duration' => '00:02:00', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Training Budget Allocation',    'duration' => '00:01:30', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Vendor Contract Renewal',       'duration' => '00:02:00', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Bonus Pool Distribution',       'duration' => '00:02:00', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Software License Budget',       'duration' => '00:01:30', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Hiring Budget Approval',        'duration' => '00:02:00', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Emergency Fund Reserve',        'duration' => '00:01:30', 'vote_methode' => 'select_one',      'max_choices' => 1],
            ],
            '400001' => [
                ['name' => 'Event Date',                    'duration' => '00:02:00', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Event Venue Type',              'duration' => '00:02:00', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Catering Options',              'duration' => '00:02:00', 'vote_methode' => 'select_multiple', 'max_choices' => 3],
                ['name' => 'Event Theme',                   'duration' => '00:01:30', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Activity Preferences',          'duration' => '00:02:00', 'vote_methode' => 'select_multiple', 'max_choices' => 2],
                ['name' => 'Budget Range',                  'duration' => '00:01:30', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Dress Code',                    'duration' => '00:01:00', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Guest Speaker Topic',           'duration' => '00:02:00', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Event Duration',                'duration' => '00:01:30', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Music Genre',                   'duration' => '00:01:00', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Transportation Options',        'duration' => '00:01:30', 'vote_methode' => 'select_multiple', 'max_choices' => 2],
                ['name' => 'After-Party Preference',        'duration' => '00:01:00', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Souvenir Type',                 'duration' => '00:01:00', 'vote_methode' => 'select_one',      'max_choices' => 1],
            ],
            '400002' => [
                ['name' => 'Senior Dev Candidate',          'duration' => '00:03:00', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'UX Designer Candidate',         'duration' => '00:03:00', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Interview Process Format',      'duration' => '00:02:00', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Technical Test Difficulty',     'duration' => '00:01:30', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Remote vs On-site Hire',        'duration' => '00:02:00', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Salary Range Approval',         'duration' => '00:02:00', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Onboarding Duration',           'duration' => '00:01:30', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Benefits Package Option',       'duration' => '00:02:00', 'vote_methode' => 'select_multiple', 'max_choices' => 3],
                ['name' => 'Job Board Selection',           'duration' => '00:01:00', 'vote_methode' => 'select_multiple', 'max_choices' => 2],
                ['name' => 'Interview Panel Size',          'duration' => '00:01:00', 'vote_methode' => 'select_one',      'max_choices' => 1],
            ],
            '500001' => [
                ['name' => 'Most Impactful Tech Trend',     'duration' => '00:02:00', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'AI Tool of the Year',           'duration' => '00:02:00', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Best Open Source Contribution', 'duration' => '00:02:00', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Biggest Security Concern',      'duration' => '00:01:30', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Remote Work Tool',              'duration' => '00:01:30', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Favorite Tech Conference',      'duration' => '00:01:30', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Most Promising Startup',        'duration' => '00:02:00', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Best Developer Experience Tool','duration' => '00:01:30', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Top Cloud Service',             'duration' => '00:01:30', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Best Tech Podcast',             'duration' => '00:01:00', 'vote_methode' => 'select_one',      'max_choices' => 1],
            ],
            '500002' => [
                ['name' => 'Q4 Feature Priority',           'duration' => '00:03:00', 'vote_methode' => 'select_multiple', 'max_choices' => 3],
                ['name' => 'Next Major Version Theme',      'duration' => '00:02:00', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Deprecation Candidates',        'duration' => '00:02:00', 'vote_methode' => 'select_multiple', 'max_choices' => 2],
                ['name' => 'API Breaking Change Approval',  'duration' => '00:02:00', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Performance Milestone Target',  'duration' => '00:01:30', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Platform Expansion Priority',   'duration' => '00:02:00', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Open Source Strategy',          'duration' => '00:01:30', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Security Audit Scope',          'duration' => '00:01:30', 'vote_methode' => 'select_multiple', 'max_choices' => 2],
                ['name' => 'Localization Priority',         'duration' => '00:01:30', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Analytics Feature Scope',       'duration' => '00:02:00', 'vote_methode' => 'select_multiple', 'max_choices' => 3],
                ['name' => 'Accessibility Roadmap',         'duration' => '00:01:30', 'vote_methode' => 'select_one',      'max_choices' => 1],
                ['name' => 'Partnership Integration',       'duration' => '00:02:00', 'vote_methode' => 'select_one',      'max_choices' => 1],
            ],
        ];

        $ownerMap = [
            '100001' => 'admin@vote.test', '100002' => 'admin@vote.test',
            '200001' => 'alice@vote.test', '200002' => 'alice@vote.test',
            '300001' => 'bob@vote.test',   '300002' => 'bob@vote.test',
            '400001' => 'carol@vote.test', '400002' => 'carol@vote.test',
            '500001' => 'david@vote.test', '500002' => 'david@vote.test',
        ];

        foreach ($data as $roomCode => $topics) {
            $room  = Room::where('code', $roomCode)->first();
            $owner = User::where('email', $ownerMap[$roomCode])->first();
            foreach ($topics as $topic) {
                Topic::firstOrCreate(
                    ['name' => $topic['name'], 'room_id' => $room->id],
                    [
                        'name'         => $topic['name'],
                        'duration'     => $topic['duration'],
                        'vote_methode' => $topic['vote_methode'],
                        'max_choices'  => $topic['max_choices'],
                        'room_id'      => $room->id,
                        'user_id'      => $owner->id,
                    ]
                );
            }
        }
    }
}
