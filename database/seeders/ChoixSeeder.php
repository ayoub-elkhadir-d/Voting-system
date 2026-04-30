<?php

namespace Database\Seeders;

use App\Models\choix;
use App\Models\Room;
use App\Models\Topic;
use Illuminate\Database\Seeder;

class ChoixSeeder extends Seeder
{
    public function run(): void
    {
        // choix fillable: name, topic_id, room_id
        // [room_code => [topic_name => [choices]]]
        $data = [
            '100001' => [
                'Best City for Next Meetup'      => ['Paris', 'Berlin', 'Amsterdam', 'Lisbon', 'Barcelona'],
                'Preferred Event Format'         => ['In-person', 'Online', 'Hybrid', 'Workshop'],
                'Favorite Programming Language'  => ['PHP', 'Python', 'JavaScript', 'Go', 'Rust', 'TypeScript'],
                'Best Learning Platform'         => ['Udemy', 'Coursera', 'YouTube', 'Pluralsight'],
                'Top Open Source Project'        => ['Laravel', 'React', 'Linux', 'Kubernetes', 'PostgreSQL'],
                'Preferred Communication Tool'   => ['Slack', 'Discord', 'Teams', 'Telegram'],
                'Best Code Editor'               => ['VS Code', 'Neovim', 'JetBrains', 'Sublime Text'],
                'Favorite Cloud Provider'        => ['AWS', 'GCP', 'Azure', 'DigitalOcean'],
                'Most Useful Community Resource' => ['Blog', 'Discord', 'YouTube', 'Newsletter', 'Podcast'],
                'Next Community Challenge Topic' => ['AI/ML', 'Web3', 'DevOps', 'Security', 'Performance'],
            ],
            '100002' => [
                'Sprint Goal Priority'           => ['Feature Delivery', 'Bug Fixes', 'Tech Debt', 'Performance'],
                'Story Point Scale'              => ['Fibonacci', 'T-shirt Sizes', 'Linear 1-10', 'Powers of 2'],
                'Velocity Target'                => ['20 pts', '30 pts', '40 pts', '50 pts'],
                'Tech Debt vs Features'          => ['80% Features', '70/30', '60/40', '50/50'],
                'Definition of Done'             => ['Tests Pass', 'Code Reviewed', 'Deployed to Staging', 'Docs Updated', 'QA Approved'],
                'Retrospective Format'           => ['Start/Stop/Continue', '4Ls', 'Mad/Sad/Glad', 'Sailboat'],
                'Daily Standup Time'             => ['9:00 AM', '9:30 AM', '10:00 AM', '10:30 AM'],
                'Sprint Length'                  => ['1 Week', '2 Weeks', '3 Weeks', '4 Weeks'],
                'Release Strategy'               => ['Continuous Deployment', 'Weekly Release', 'Bi-weekly', 'Monthly'],
                'Code Freeze Policy'             => ['2 days before', '1 day before', 'No freeze', 'Feature flags only'],
                'On-Call Rotation'               => ['Weekly', 'Bi-weekly', 'Monthly', 'Volunteer-based'],
                'Pair Programming Frequency'     => ['Daily', 'Weekly', 'On complex tasks only', 'Never'],
            ],
            '200001' => [
                'Best Frontend Framework'        => ['React', 'Vue', 'Angular', 'Svelte', 'SolidJS'],
                'Best Backend Framework'         => ['Laravel', 'Django', 'NestJS', 'Spring Boot', 'FastAPI'],
                'Preferred Database'             => ['MySQL', 'PostgreSQL', 'MongoDB', 'SQLite', 'Redis'],
                'Container Technology'           => ['Docker', 'Podman', 'LXC', 'Kubernetes'],
                'CI/CD Tool Preference'          => ['GitHub Actions', 'GitLab CI', 'Jenkins', 'CircleCI'],
                'Testing Framework'              => ['PHPUnit', 'Jest', 'Pytest', 'Cypress', 'Playwright'],
                'API Style Preference'           => ['REST', 'GraphQL', 'gRPC', 'tRPC'],
                'Agile Methodology'              => ['Scrum', 'Kanban', 'SAFe', 'XP', 'Shape Up'],
                'Monitoring Tool'                => ['Grafana', 'Datadog', 'New Relic', 'Prometheus', 'Sentry'],
                'Version Control Workflow'       => ['Git Flow', 'Trunk-based', 'GitHub Flow', 'Feature Flags'],
                'Code Review Tool'               => ['GitHub PRs', 'GitLab MRs', 'Gerrit', 'Phabricator'],
            ],
            '200002' => [
                'Color Palette Selection'        => ['Blue & White', 'Dark & Neon', 'Earth Tones', 'Monochrome', 'Pastel'],
                'Typography Choice'              => ['Inter', 'Roboto', 'Poppins', 'Geist', 'Custom'],
                'Layout Style'                   => ['Sidebar Nav', 'Top Nav', 'Dashboard Grid', 'Minimal'],
                'Icon Set Preference'            => ['Heroicons', 'Lucide', 'Font Awesome', 'Material Icons'],
                'Animation Level'                => ['None', 'Subtle', 'Moderate', 'Rich'],
                'Component Library'              => ['Tailwind UI', 'shadcn/ui', 'MUI', 'Ant Design', 'Chakra UI'],
                'Dark Mode Priority'             => ['Required', 'Nice to have', 'Not needed', 'System default only'],
                'Accessibility Standard'         => ['WCAG AA', 'WCAG AAA', 'Basic only', 'Not a priority'],
                'Responsive Breakpoints'         => ['Mobile', 'Tablet', 'Desktop', 'Wide Screen', '4K'],
                'Design System Adoption'         => ['Full adoption', 'Partial', 'Start fresh', 'Evaluate first'],
            ],
            '300001' => [
                'Most Requested Feature'         => ['Dark Mode', 'Mobile App', 'API v2', 'Analytics', 'Webhooks', '2FA'],
                'Biggest Pain Point'             => ['Slow Performance', 'Missing Features', 'Poor Docs', 'Bugs', 'Pricing'],
                'UI Improvement Priority'        => ['Navigation', 'Dashboard', 'Forms', 'Tables', 'Charts'],
                'Mobile App Priority'            => ['iOS First', 'Android First', 'Both Simultaneously', 'PWA Only'],
                'Notification Preferences'       => ['Email', 'Push', 'SMS', 'In-app', 'Slack'],
                'Pricing Model Preference'       => ['Free Tier', 'Pay-as-you-go', 'Flat Monthly', 'Per Seat'],
                'Support Channel Preference'     => ['Live Chat', 'Email', 'Forum', 'Video Call'],
                'Integration Priority'           => ['Slack', 'GitHub', 'Jira', 'Zapier', 'Google Workspace'],
                'Documentation Format'           => ['Written Guides', 'Video Tutorials', 'Interactive Demos', 'API Reference'],
                'Release Cadence Preference'     => ['Weekly', 'Bi-weekly', 'Monthly', 'Quarterly'],
                'Performance vs Features'        => ['Prioritize Performance', 'Prioritize Features', 'Balance Both', 'User decides'],
                'Beta Testing Interest'          => ['Yes, always', 'Yes, sometimes', 'No', 'Depends on feature'],
            ],
            '300002' => [
                'Q3 Budget Allocation'           => ['Engineering', 'Marketing', 'Sales', 'Operations', 'R&D'],
                'Infrastructure Spend Limit'     => ['$5k/mo', '$10k/mo', '$20k/mo', '$50k/mo'],
                'Marketing Budget Share'         => ['10%', '15%', '20%', '25%', '30%'],
                'Cost Cutting Area'              => ['SaaS Tools', 'Cloud Costs', 'Contractors', 'Office Expenses'],
                'Training Budget Allocation'     => ['$500/person', '$1000/person', '$2000/person', 'Team pool'],
                'Vendor Contract Renewal'        => ['Renew as-is', 'Renegotiate', 'Find Alternative', 'Cancel'],
                'Bonus Pool Distribution'        => ['Equal Split', 'Performance-based', 'Seniority-based', 'Manager decides'],
                'Software License Budget'        => ['$1k/mo', '$3k/mo', '$5k/mo', '$10k/mo'],
                'Hiring Budget Approval'         => ['Approve all', 'Approve critical only', 'Freeze hiring', 'Case by case'],
                'Emergency Fund Reserve'         => ['5%', '10%', '15%', '20%'],
            ],
            '400001' => [
                'Event Date'                     => ['January', 'March', 'June', 'September', 'November'],
                'Event Venue Type'               => ['Hotel', 'Co-working Space', 'University', 'Outdoor', 'Online'],
                'Catering Options'               => ['Buffet', 'Sit-down Dinner', 'Food Trucks', 'Cocktail', 'Vegan Only'],
                'Event Theme'                    => ['Tech & Innovation', 'Networking', 'Hackathon', 'Workshop Day'],
                'Activity Preferences'           => ['Talks', 'Workshops', 'Networking', 'Games', 'Panel Discussion'],
                'Budget Range'                   => ['Under $5k', '$5k-$10k', '$10k-$20k', 'Over $20k'],
                'Dress Code'                     => ['Casual', 'Smart Casual', 'Business', 'Themed'],
                'Guest Speaker Topic'            => ['AI', 'Startups', 'Leadership', 'Open Source', 'Security'],
                'Event Duration'                 => ['Half Day', 'Full Day', '2 Days', '3 Days'],
                'Music Genre'                    => ['Electronic', 'Jazz', 'Pop', 'No Music', 'Live Band'],
                'Transportation Options'         => ['Shuttle Bus', 'Carpool', 'Public Transit', 'Bike', 'Self-arranged'],
                'After-Party Preference'         => ['Yes', 'No', 'Optional', 'Virtual Only'],
                'Souvenir Type'                  => ['T-shirt', 'Sticker Pack', 'Notebook', 'Tote Bag'],
            ],
            '400002' => [
                'Senior Dev Candidate'           => ['Candidate A', 'Candidate B', 'Candidate C', 'None - repost'],
                'UX Designer Candidate'          => ['Candidate X', 'Candidate Y', 'Candidate Z', 'None - repost'],
                'Interview Process Format'       => ['1 Round', '2 Rounds', '3 Rounds', '4 Rounds'],
                'Technical Test Difficulty'      => ['Easy', 'Medium', 'Hard', 'Take-home project'],
                'Remote vs On-site Hire'         => ['Remote Only', 'On-site Only', 'Hybrid', 'Flexible'],
                'Salary Range Approval'          => ['$60k-$80k', '$80k-$100k', '$100k-$120k', '$120k+'],
                'Onboarding Duration'            => ['1 Week', '2 Weeks', '1 Month', '3 Months'],
                'Benefits Package Option'        => ['Health Insurance', 'Stock Options', 'Remote Stipend', 'Learning Budget', 'Gym'],
                'Job Board Selection'            => ['LinkedIn', 'Indeed', 'Stack Overflow', 'AngelList', 'Company site'],
                'Interview Panel Size'           => ['1 person', '2 people', '3 people', '4+ people'],
            ],
            '500001' => [
                'Most Impactful Tech Trend'      => ['Generative AI', 'Edge Computing', 'Web3', 'Quantum Computing', 'AR/VR'],
                'AI Tool of the Year'            => ['ChatGPT', 'GitHub Copilot', 'Midjourney', 'Claude', 'Gemini'],
                'Best Open Source Contribution'  => ['Linux Kernel', 'VS Code', 'React', 'Kubernetes', 'PostgreSQL'],
                'Biggest Security Concern'       => ['Ransomware', 'Supply Chain Attacks', 'Phishing', 'Zero-days', 'Insider Threats'],
                'Remote Work Tool'               => ['Slack', 'Zoom', 'Notion', 'Linear', 'Loom'],
                'Favorite Tech Conference'       => ['AWS re:Invent', 'Google I/O', 'WWDC', 'KubeCon', 'JSConf'],
                'Most Promising Startup'         => ['AI Startup', 'Climate Tech', 'FinTech', 'HealthTech', 'EdTech'],
                'Best Developer Experience Tool' => ['Vercel', 'Railway', 'Render', 'Fly.io', 'Netlify'],
                'Top Cloud Service'              => ['AWS Lambda', 'GCP BigQuery', 'Azure DevOps', 'Cloudflare Workers', 'Supabase'],
                'Best Tech Podcast'              => ['Syntax', 'Lex Fridman', 'Software Engineering Daily', 'The Changelog'],
            ],
            '500002' => [
                'Q4 Feature Priority'            => ['Search', 'Notifications', 'Reporting', 'Integrations', 'Mobile', 'Performance'],
                'Next Major Version Theme'       => ['Scalability', 'Developer Experience', 'AI Integration', 'Enterprise Features'],
                'Deprecation Candidates'         => ['Legacy API v1', 'Old Dashboard', 'XML Export', 'Flash Reports', 'SOAP Endpoint'],
                'API Breaking Change Approval'   => ['Approve with guide', 'Reject', 'Delay 6 months', 'Needs discussion'],
                'Performance Milestone Target'   => ['50ms p99', '100ms p99', '200ms p99', 'No specific target'],
                'Platform Expansion Priority'    => ['iOS', 'Android', 'Desktop App', 'CLI Tool', 'Browser Extension'],
                'Open Source Strategy'           => ['Open core', 'Fully open', 'Stay closed', 'Selective modules'],
                'Security Audit Scope'           => ['API', 'Auth', 'Database', 'Frontend', 'Infrastructure'],
                'Localization Priority'          => ['French', 'Spanish', 'Arabic', 'German', 'Japanese'],
                'Analytics Feature Scope'        => ['User Behavior', 'Funnel Analysis', 'Retention', 'Revenue', 'Custom Events'],
                'Accessibility Roadmap'          => ['WCAG AA by Q2', 'WCAG AA by Q4', 'AAA long-term', 'Not prioritized'],
                'Partnership Integration'        => ['Salesforce', 'HubSpot', 'Stripe', 'Twilio', 'SendGrid'],
            ],
        ];

        foreach ($data as $roomCode => $topics) {
            $room = Room::where('code', $roomCode)->first();
            foreach ($topics as $topicName => $choices) {
                $topic = Topic::where('name', $topicName)->where('room_id', $room->id)->first();
                foreach ($choices as $choiceName) {
                    choix::firstOrCreate(
                        ['name' => $choiceName, 'topic_id' => $topic->id],
                        ['room_id' => $room->id]
                    );
                }
            }
        }
    }
}
