<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin — {{ $room->name }}</title>
@vite(['resources/js/app.js'])
<style>
* { margin:0; padding:0; box-sizing:border-box; font-family:'Segoe UI',sans-serif; }

body { background:#dfdfdf; color:#1a1a2e; min-height:100vh; display:flex; flex-direction:column; }

/* ── layout ── */
.layout {
    display:flex;
    flex:1;
    gap:0;
    height:calc(100vh - 56px); /* subtract navbar height */
}

/* ── sidebar ── */
.sidebar {
    width:280px;
    flex-shrink:0;
    background:#fff;
    border-right:1px solid #e0e0e0;
    display:flex;
    flex-direction:column;
    overflow:hidden;
}

.sidebar-header {
    padding:20px 20px 14px;
    border-bottom:1px solid #f0f0f0;
}

.sidebar-title {
    font-size:13px;
    font-weight:700;
    letter-spacing:1px;
    text-transform:uppercase;
    color:#aaa;
    margin-bottom:4px;
}

.room-name {
    font-size:16px;
    font-weight:800;
    color:#1a1a2e;
    white-space:nowrap;
    overflow:hidden;
    text-overflow:ellipsis;
}

.sidebar-body { flex:1; overflow-y:auto; padding:12px 0; }

.sidebar-section-label {
    font-size:11px;
    font-weight:700;
    letter-spacing:1px;
    text-transform:uppercase;
    color:#bbb;
    padding:10px 20px 6px;
}

.sidebar-item {
    display:flex;
    align-items:center;
    gap:10px;
    padding:10px 20px;
    cursor:default;
    border-left:3px solid transparent;
    transition:background 0.15s;
}

.sidebar-item.is-active {
    background:#e8f0fe;
    border-left-color:#1a73e8;
}

.sidebar-item.is-pending {
    opacity:0.7;
}

.sidebar-dot {
    width:8px;
    height:8px;
    border-radius:50%;
    flex-shrink:0;
}

.dot-active  { background:#1a73e8; animation:pulse 1.5s infinite; }
.dot-pending { background:#ccc; }

@keyframes pulse {
    0%,100% { opacity:1; transform:scale(1); }
    50%      { opacity:0.5; transform:scale(1.3); }
}

.sidebar-item-name {
    font-size:14px;
    font-weight:600;
    white-space:nowrap;
    overflow:hidden;
    text-overflow:ellipsis;
}

.sidebar-item-badge {
    margin-left:auto;
    font-size:11px;
    font-weight:700;
    padding:2px 8px;
    border-radius:20px;
    flex-shrink:0;
}

.badge-live      { background:#e3f2fd; color:#1565c0; }
.badge-pending   { background:#f5f5f5; color:#999; }

/* start button inside sidebar */
.sidebar-start-btn {
    margin-left:auto;
    background:#1a73e8;
    color:#fff;
    border:none;
    padding:4px 12px;
    border-radius:8px;
    font-size:12px;
    font-weight:700;
    cursor:pointer;
    flex-shrink:0;
    transition:0.2s;
}
.sidebar-start-btn:hover { background:#1558b0; }

/* ── main content ── */
.main {
    flex:1;
    overflow-y:auto;
    padding:30px 36px;
}

.main-title {
    font-size:22px;
    font-weight:800;
    margin-bottom:24px;
    color:#1a1a2e;
}

.main-title span { color:#1a73e8; }

/* ── section label ── */
.section-label {
    font-size:12px;
    font-weight:700;
    letter-spacing:1px;
    text-transform:uppercase;
    color:#aaa;
    margin:28px 0 12px;
}

/* ── topic card ── */
.topic-card {
    background:#fff;
    border-radius:16px;
    padding:24px 28px;
    margin-bottom:16px;
    box-shadow:0 4px 16px rgba(0,0,0,0.06);
    border:1px solid #e0e0e0;
}

.topic-card.active-card {
    border:2px solid #1a73e8;
    box-shadow:0 6px 24px rgba(26,115,232,0.14);
}

.topic-header {
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}

.topic-name { font-size:18px; font-weight:700; }

.badge-completed {
    background:#e8f5e9;
    color:#2e7d32;
    padding:4px 12px;
    border-radius:20px;
    font-size:12px;
    font-weight:700;
}

.badge-active {
    background:#e3f2fd;
    color:#1565c0;
    padding:4px 12px;
    border-radius:20px;
    font-size:12px;
    font-weight:700;
    animation:pulse 1.5s infinite;
}

/* ── choice rows ── */
.choice-row {
    display:flex;
    align-items:center;
    gap:12px;
    margin-bottom:10px;
}

.choice-label { width:140px; font-size:14px; font-weight:600; flex-shrink:0; }

.bar-wrap {
    flex:1;
    background:#f0f0f0;
    border-radius:8px;
    height:22px;
    overflow:hidden;
}

.bar-fill {
    height:100%;
    background:#1a73e8;
    border-radius:8px;
    transition:width 0.6s ease;
    min-width:2px;
}

.vote-count {
    width:70px;
    text-align:right;
    font-size:14px;
    font-weight:700;
    color:#555;
}

/* ── stop button ── */
.stop-btn {
    margin-top:22px;
    background:#e74c3c;
    color:#fff;
    border:none;
    padding:11px 32px;
    border-radius:10px;
    font-weight:700;
    font-size:15px;
    cursor:pointer;
    transition:0.2s;
}
.stop-btn:hover { background:#c0392b; transform:translateY(-1px); }

.empty-state {
    text-align:center;
    color:#bbb;
    padding:60px 0;
    font-size:15px;
}
</style>
</head>
<body>
@include('components.navbar')

@php
    $completed = $topics->where('status', 'completed');
    $active    = $topics->firstWhere('status', 'active');
    $pending   = \App\Models\Topic::where('room_id', $room->id)
                    ->where('status', 'pending')
                    ->get();
@endphp

<div class="layout">

    {{-- ── Sidebar ── --}}
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-title">Room</div>
            <div class="room-name">{{ $room->name }}</div>
        </div>

        <div class="sidebar-body">

            @if($active)
                <div class="sidebar-section-label">Active</div>
                <div class="sidebar-item is-active">
                    <div class="sidebar-dot dot-active"></div>
                    <div class="sidebar-item-name">{{ $active->name }}</div>
                    <span class="sidebar-item-badge badge-live">Live</span>
                </div>
            @endif

            @if($pending->isNotEmpty())
                <div class="sidebar-section-label">Pending</div>
                @foreach($pending as $pt)
                    <div class="sidebar-item is-pending">
                        <div class="sidebar-dot dot-pending"></div>
                        <div class="sidebar-item-name">{{ $pt->name }}</div>
                        @if(!$active)
                            <form action="/rooms/{{ $room->id }}/topic/{{ $pt->id }}/start" method="POST">
                                @csrf
                                <button type="submit" class="sidebar-start-btn">▶ Start</button>
                            </form>
                        @else
                            <span class="sidebar-item-badge badge-pending">Pending</span>
                        @endif
                    </div>
                @endforeach
            @endif

        </div>
    </aside>

    {{-- ── Main ── --}}
    <main class="main">
        <div class="main-title">Admin — <span>{{ $room->name }}</span></div>

        {{-- Active topic --}}
        <div class="section-label">Currently Voting</div>

        @if($active)
            @php $totalVotes = $active->choix->sum('vote_count'); @endphp
            <div class="topic-card active-card" id="activeCard">
                <div class="topic-header">
                    <div class="topic-name">{{ $active->name }}</div>
                    <span class="badge-active">● Live</span>
                </div>

                @foreach($active->choix as $choice)
                    @php $pct = $totalVotes > 0 ? round($choice->vote_count / $totalVotes * 100) : 0; @endphp
                    <div class="choice-row" data-choice-id="{{ $choice->id }}">
                        <div class="choice-label">{{ $choice->name }}</div>
                        <div class="bar-wrap">
                            <div class="bar-fill" style="width:{{ $pct }}%"></div>
                        </div>
                        <div class="vote-count">
                            <span class="count-val">{{ $choice->vote_count }}</span>
                        </div>
                    </div>
                @endforeach

                <form action="/rooms/{{ $room->id }}/topic/{{ $active->id }}/stop" method="POST">
                    @csrf
                    <button type="submit" class="stop-btn">⏹ Stop Voting</button>
                </form>
            </div>
        @else
            <div class="empty-state">No topic is currently being voted on.<br>Start one from the sidebar.</div>
        @endif

        {{-- Completed topics --}}
        @if($completed->isNotEmpty())
            <div class="section-label">Completed Topics</div>

            @foreach($completed as $topic)
                @php $totalVotes = $topic->choix->sum('vote_count'); @endphp
                <div class="topic-card">
                    <div class="topic-header">
                        <div class="topic-name">{{ $topic->name }}</div>
                        <span class="badge-completed">✔ Completed</span>
                    </div>

                    @foreach($topic->choix as $choice)
                        @php $pct = $totalVotes > 0 ? round($choice->vote_count / $totalVotes * 100) : 0; @endphp
                        <div class="choice-row">
                            <div class="choice-label">{{ $choice->name }}</div>
                            <div class="bar-wrap">
                                <div class="bar-fill" style="width:{{ $pct }}%"></div>
                            </div>
                            <div class="vote-count">
                                {{ $choice->vote_count }}
                                <small style="color:#aaa;font-weight:400">({{ $pct }}%)</small>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        @endif
    </main>

</div>

<script>
<script>
const roomId = {{ $room->id }};

@if($active)
const activeTopicId = {{ $active->id }};

if (typeof Echo !== 'undefined') {
    Echo.channel('room.' + roomId)

        .listen('.vote.updated', function(e) {

            if (e.topicId === activeTopicId) {

                const data = e.choices;

                let total = 0;

                data.forEach(function(item) {
                    total = total + item.votes;
                });

                data.forEach(function(item) {

                    const row = document.querySelector('[data-choice-id="' + item.id + '"]');
                    if (!row) return;

                    let percent = 0;

                    if (total > 0) {
                        percent = Math.round((item.votes / total) * 100);
                    }

                    row.querySelector('.bar-fill').style.width = percent + '%';
                    row.querySelector('.count-val').innerText = item.votes;
                });
            }
        })

        .listen('.topic.ended', function() {
            window.location.reload();
        });
}
@endif
</script>
</body>
</html>
