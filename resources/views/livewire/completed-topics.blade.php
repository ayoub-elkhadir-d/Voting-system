<div>
    @if($completed->isNotEmpty())
    <div class="section-label"> Completed Topics</div>

    @foreach($completed as $topic)
    @php $totalVotes = $topic->choix->sum('vote_count'); @endphp

    <div class="topic-card">

        <!-- Normal View -->
        <div class="topic-normal-{{ $topic->id }}">
            <div class="topic-header">
                <div class="topic-name" style="font-size:20px;background:none;color:#1f3a6b;">
                    {{ $topic->name }}
                </div>
                <div style="display:flex;gap:10px;align-items:center;">
                    <span class="badge-completed">✓ Completed</span>
                    <button
                        onclick="Livewire.dispatch('restart-topic', { topicId: {{ $topic->id }} })"
                        style="background:#f39c12;border:none;padding:6px 14px;border-radius:20px;color:#fff;font-size:12px;font-weight:700;cursor:pointer;">
                        ↺ Restart
                    </button>
                    <button
                        onclick="document.querySelector('.topic-normal-{{ $topic->id }}').style.display='none'; document.querySelector('.topic-stats-{{ $topic->id }}').style.display='block';"
                        style="background:#1a73e8;border:none;padding:6px 14px;border-radius:20px;color:#fff;font-size:12px;font-weight:700;cursor:pointer;">
                         Statistics
                    </button>
                </div>
            </div>

            @foreach($topic->choix as $choice)
            @php $pct = $totalVotes > 0 ? round($choice->vote_count / $totalVotes * 100) : 0; @endphp
            <div class="choice-row">
                <div class="choice-label">{{ $choice->name }}</div>
                <div class="bar-wrap">
                    <div class="bar-fill" style="width:{{ $pct }}%;background:#9aaebf;"></div>
                </div>
                <div class="vote-count">
                    {{ $choice->vote_count }}
                    <small style="color:#8895aa;">({{ $pct }}%)</small>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Statistics View -->
        @php
            $topChoice    = $topic->choix->sortByDesc('vote_count')->first();
            $participants = $topic->choix->sum('vote_count');
            $timeline     = $voteTimelines[$topic->id] ?? collect();
        @endphp
        <div class="topic-stats-{{ $topic->id }}" style="display:none;">

            <!-- Header -->
            <div class="topic-header">
                <div class="topic-name" style="font-size:20px;background:none;color:#1f3a6b;">{{ $topic->name }} — Statistics</div>
                <button onclick="document.querySelector('.topic-stats-{{ $topic->id }}').style.display='none';document.querySelector('.topic-normal-{{ $topic->id }}').style.display='block';"
                    style="background:#6c757d;border:none;padding:6px 14px;border-radius:20px;color:#fff;font-size:12px;font-weight:700;cursor:pointer;">← Back</button>
            </div>

            <!-- Summary cards -->
            <div style="display:flex;gap:12px;margin-bottom:20px;flex-wrap:wrap;">
                <div style="flex:1;min-width:100px;background:#f0f7ff;border-radius:14px;padding:14px;text-align:center;">
                    <div style="font-size:10px;font-weight:700;color:#aaa;text-transform:uppercase;">Total Votes</div>
                    <div style="font-size:28px;font-weight:800;color:#1a73e8;">{{ $totalVotes }}</div>
                </div>
                <div style="flex:1;min-width:100px;background:#f0fff4;border-radius:14px;padding:14px;text-align:center;">
                    <div style="font-size:10px;font-weight:700;color:#aaa;text-transform:uppercase;">Participants</div>
                    <div style="font-size:28px;font-weight:800;color:#2e7d32;">{{ $participants }}</div>
                </div>
                <div style="flex:1;min-width:100px;background:#fffbf0;border-radius:14px;padding:14px;text-align:center;">
                    <div style="font-size:10px;font-weight:700;color:#aaa;text-transform:uppercase;">Top Choice</div>
                    <div style="font-size:15px;font-weight:800;color:#f39c12;margin-top:6px;">{{ $topChoice?->name ?? '—' }}</div>
                </div>
            </div>

            <!-- Two charts side by side -->
            <div style="display:flex;gap:16px;flex-wrap:wrap;">

                <!-- Chart 1: Pie chart — vote share per choice -->
                <div style="flex:1;min-width:200px;background:#f8faff;border-radius:14px;padding:16px;">
                    <div style="font-size:11px;font-weight:700;color:#aaa;text-transform:uppercase;letter-spacing:1px;margin-bottom:8px;">Vote Share</div>
                    <div id="pie-{{ $topic->id }}" style="height:200px;"></div>
                    <script>
                        // Queue this chart to draw once Google Charts is ready
                        window.chartsToLoad = window.chartsToLoad || [];
                        window.chartsToLoad.push(function () {

                            // Step 1: Create a table with Choice name and vote count
                            var data = new google.visualization.DataTable();
                            data.addColumn('string', 'Choice');
                            data.addColumn('number', 'Votes');

                            // Step 2: Add one row per choice
                            data.addRows([
                                @foreach($topic->choix->sortByDesc('vote_count') as $choice)
                                ['{{ addslashes($choice->name) }}', {{ $choice->vote_count }}],
                                @endforeach
                            ]);

                            // Step 3: Options — pieHole makes it a donut shape
                            var options = {
                                pieHole: 0.45,
                                height: 200,
                                legend: { position: 'right', textStyle: { fontSize: 11 } },
                                chartArea: { left: 10, top: 10, width: '60%', height: '85%' },
                                tooltip: { text: 'both' },
                                backgroundColor: 'transparent',
                            };

                            // Step 4: Draw
                            var chart = new google.visualization.PieChart(document.getElementById('pie-{{ $topic->id }}'));
                            chart.draw(data, options);
                        });
                    </script>
                </div>

                <!-- Chart 2: Column chart — votes per minute -->
                <div style="flex:2;min-width:220px;background:#f8faff;border-radius:14px;padding:16px;">
                    <div style="font-size:11px;font-weight:700;color:#aaa;text-transform:uppercase;letter-spacing:1px;margin-bottom:8px;">Votes Over Time</div>
                    <div id="timeline-{{ $topic->id }}" style="height:200px;"></div>
                    <script>
                        window.chartsToLoad = window.chartsToLoad || [];
                        window.chartsToLoad.push(function () {

                            // Step 1: Create a table with Time and vote count
                            var data = new google.visualization.DataTable();
                            data.addColumn('string', 'Time');
                            data.addColumn('number', 'Votes');

                            // Step 2: Add one row per minute
                            @if($timeline->isEmpty())
                            data.addRows([['No data', 0]]);
                            @else
                            data.addRows([
                                @foreach($timeline as $row)
                                ['{{ $row->minute }}', {{ $row->cnt }}],
                                @endforeach
                            ]);
                            @endif

                            // Step 3: Options
                            var options = {
                                height: 200,
                                legend: { position: 'none' },
                                bar: { groupWidth: '60%' },
                                chartArea: { left: 35, top: 10, width: '90%', height: '75%' },
                                colors: ['#1a73e8'],
                                backgroundColor: 'transparent',
                                hAxis: { textStyle: { fontSize: 10 } },
                                vAxis: { minValue: 0, format: '0', textStyle: { fontSize: 10 } },
                            };

                            // Step 4: Draw
                            var chart = new google.visualization.ColumnChart(document.getElementById('timeline-{{ $topic->id }}'));
                            chart.draw(data, options);
                        });
                    </script>
                </div>

            </div>
        </div>

    </div>
    @endforeach
    @endif
</div>
