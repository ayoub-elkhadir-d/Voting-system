<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; font-family:'Segoe UI',sans-serif; }
        body { background:#f5f7fb; color:#1a1a2e; }

        .dash { max-width:1100px; margin:auto; padding:36px 24px; }

        /* Welcome */
        .welcome {
            background:linear-gradient(135deg,#1a73e8,#4a9eff);
            border-radius:20px;
            padding:32px 36px;
            color:#fff;
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:32px;
            box-shadow:0 8px 28px rgba(26,115,232,0.25);
        }
        .welcome-text h1 { font-size:26px; font-weight:800; margin-bottom:6px; }
        .welcome-text p  { font-size:14px; opacity:0.85; }
        .welcome-actions { display:flex; gap:12px; }
        .btn-white {
            background:#fff;
            color:#1a73e8;
            border:none;
            padding:10px 22px;
            border-radius:40px;
            font-weight:700;
            font-size:13px;
            cursor:pointer;
            text-decoration:none;
            display:inline-flex;
            align-items:center;
            gap:8px;
            transition:0.2s;
        }
        .btn-white:hover { background:#e8f0fe; }
        .btn-outline-white {
            background:transparent;
            color:#fff;
            border:2px solid rgba(255,255,255,0.6);
            padding:10px 22px;
            border-radius:40px;
            font-weight:700;
            font-size:13px;
            cursor:pointer;
            text-decoration:none;
            display:inline-flex;
            align-items:center;
            gap:8px;
            transition:0.2s;
        }
        .btn-outline-white:hover { background:rgba(255,255,255,0.15); }

        /* Stats grid */
        .stats-grid {
            display:grid;
            grid-template-columns:repeat(4,1fr);
            gap:18px;
            margin-bottom:32px;
        }
        .stat-card {
            background:#fff;
            border-radius:18px;
            padding:24px 20px;
            display:flex;
            align-items:center;
            gap:16px;
            box-shadow:0 4px 16px rgba(0,0,0,0.06);
            border:1px solid #e6eaf0;
            transition:0.2s;
        }
        .stat-card:hover { transform:translateY(-3px); box-shadow:0 8px 24px rgba(0,0,0,0.09); }
        .stat-icon-wrap {
            width:52px; height:52px;
            border-radius:14px;
            display:flex; align-items:center; justify-content:center;
            font-size:22px;
            flex-shrink:0;
        }
        .stat-info { flex:1; }
        .stat-value { font-size:30px; font-weight:800; color:#1a1a2e; line-height:1; }
        .stat-label { font-size:12px; font-weight:600; color:#aaa; text-transform:uppercase; letter-spacing:0.7px; margin-top:4px; }

        /* Section title */
        .section-title {
            font-size:13px;
            font-weight:700;
            letter-spacing:1px;
            text-transform:uppercase;
            color:#aaa;
            margin-bottom:14px;
        }

        /* Recent rooms */
        .recent-grid {
            display:grid;
            grid-template-columns:repeat(auto-fill,minmax(200px,1fr));
            gap:16px;
            margin-bottom:32px;
        }
        .room-card {
            background:#fff;
            border-radius:16px;
            overflow:hidden;
            box-shadow:0 4px 14px rgba(0,0,0,0.06);
            border:1px solid #e6eaf0;
            text-decoration:none;
            color:inherit;
            transition:0.2s;
            display:block;
        }
        .room-card:hover { transform:translateY(-4px); box-shadow:0 10px 24px rgba(0,0,0,0.1); }
        .room-card-header {
            height:72px;
            display:flex; align-items:center; justify-content:center;
            font-size:32px; font-weight:900; color:#fff;
        }
        .room-card-body { padding:14px 16px; }
        .room-card-name { font-size:14px; font-weight:700; margin-bottom:4px; }
        .room-card-desc { font-size:12px; color:#999; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }

        /* Quick actions */
        .actions-grid {
            display:grid;
            grid-template-columns:repeat(3,1fr);
            gap:16px;
        }
        .action-card {
            background:#fff;
            border-radius:16px;
            padding:22px 20px;
            display:flex;
            align-items:center;
            gap:14px;
            box-shadow:0 4px 14px rgba(0,0,0,0.06);
            border:1px solid #e6eaf0;
            text-decoration:none;
            color:#1a1a2e;
            transition:0.2s;
        }
        .action-card:hover { background:#f0f6ff; border-color:#1a73e8; transform:translateY(-2px); }
        .action-icon { width:44px; height:44px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:18px; flex-shrink:0; }
        .action-label { font-size:14px; font-weight:700; }
        .action-sub   { font-size:11px; color:#aaa; margin-top:2px; }

        @media(max-width:768px) {
            .stats-grid { grid-template-columns:repeat(2,1fr); }
            .actions-grid { grid-template-columns:1fr; }
            .welcome { flex-direction:column; gap:20px; }
        }
    </style>
</head>
<body>

@include('components.navbar')

<div class="dash">

    {{-- Welcome Banner --}}
    <div class="welcome">
        <div class="welcome-text">
            <h1>Welcome back, {{ Auth::user()->name }} 👋</h1>
            <p>Here's an overview of your voting activity.</p>
        </div>
        <div class="welcome-actions">
            <a href="/roomcreate" class="btn-white"><i class="fa-solid fa-plus"></i> New Room</a>
            <a href="/rooms/join" class="btn-outline-white"><i class="fa-solid fa-right-to-bracket"></i> Join Room</a>
        </div>
    </div>

    {{-- Stats --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon-wrap" style="background:#e3f2fd;">
                <i class="fa-solid fa-door-open" style="color:#1565c0;"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value">{{ $totalRooms }}</div>
                <div class="stat-label">Total Rooms</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon-wrap" style="background:#f3e5f5;">
                <i class="fa-solid fa-clipboard-list" style="color:#7b1fa2;"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value">{{ $totalTopics }}</div>
                <div class="stat-label">Total Topics</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon-wrap" style="background:#fff8e1;">
                <i class="fa-solid fa-square-poll-vertical" style="color:#f57f17;"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value">{{ $totalVotes }}</div>
                <div class="stat-label">Total Votes</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon-wrap" style="background:#e8f5e9;">
                <i class="fa-solid fa-users" style="color:#2e7d32;"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value">{{ $totalMembers }}</div>
                <div class="stat-label">Total Members</div>
            </div>
        </div>
    </div>

    {{-- Recent Rooms --}}
    @if($recentRooms->isNotEmpty())
    <div class="section-title"><i class="fa-solid fa-clock-rotate-left"></i> Recent Rooms</div>
    <div class="recent-grid">
        @foreach($recentRooms as $room)
        <a href="/show/{{ $room->id }}" class="room-card">
            <div class="room-card-header" data-name="{{ $room->name }}"></div>
            <div class="room-card-body">
                <div class="room-card-name">{{ $room->name }}</div>
                <div class="room-card-desc">{{ $room->description }}</div>
            </div>
        </a>
        @endforeach
    </div>
    @endif

    {{-- Quick Actions --}}
    <div class="section-title"><i class="fa-solid fa-bolt"></i> Quick Actions</div>
    <div class="actions-grid">
        <a href="/roomcreate" class="action-card">
            <div class="action-icon" style="background:#e3f2fd;"><i class="fa-solid fa-plus" style="color:#1565c0;"></i></div>
            <div>
                <div class="action-label">Create Room</div>
                <div class="action-sub">Start a new voting session</div>
            </div>
        </a>
        <a href="/myrooms" class="action-card">
            <div class="action-icon" style="background:#f3e5f5;"><i class="fa-solid fa-door-open" style="color:#7b1fa2;"></i></div>
            <div>
                <div class="action-label">My Rooms</div>
                <div class="action-sub">Manage your rooms</div>
            </div>
        </a>
        <a href="/rooms/join" class="action-card">
            <div class="action-icon" style="background:#e8f5e9;"><i class="fa-solid fa-right-to-bracket" style="color:#2e7d32;"></i></div>
            <div>
                <div class="action-label">Join a Room</div>
                <div class="action-sub">Enter with a room code</div>
            </div>
        </a>
    </div>

</div>

<script>
    const colors = ["#4F46E5","#0EA5E9","#10B981","#F59E0B","#EF4444","#8B5CF6"];
    function getColor(name) {
        let hash = 0;
        for (let i = 0; i < name.length; i++) hash = name.charCodeAt(i) + ((hash << 5) - hash);
        return colors[Math.abs(hash) % colors.length];
    }
    document.querySelectorAll('.room-card-header').forEach(el => {
        el.textContent = (el.dataset.name || '?').charAt(0).toUpperCase();
        el.style.background = getColor(el.dataset.name || '');
    });
</script>

</body>
</html>
