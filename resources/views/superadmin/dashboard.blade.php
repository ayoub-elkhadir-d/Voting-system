<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; font-family:'Segoe UI',sans-serif; }
        body { background:#f0f2f5; color:#1a1a2e; min-height:100vh; }

        /* Layout */
        .layout { display:flex; min-height:100vh; }

        /* Sidebar */
        .sidebar {
            width:240px;
            background:#1a1a2e;
            display:flex;
            flex-direction:column;
            padding:0;
            position:fixed;
            top:0; left:0;
            height:100vh;
            z-index:100;
        }
        .sidebar-logo {
            padding:24px 20px;
            border-bottom:1px solid rgba(255,255,255,0.08);
            display:flex;
            align-items:center;
            gap:10px;
        }
        .sidebar-logo span {
            font-size:16px;
            font-weight:800;
            color:#fff;
            letter-spacing:0.5px;
        }
        .sidebar-logo .badge {
            background:#e74c3c;
            color:#fff;
            font-size:10px;
            font-weight:700;
            padding:2px 7px;
            border-radius:20px;
        }
        .sidebar-nav { padding:16px 0; flex:1; }
        .nav-item {
            display:flex;
            align-items:center;
            gap:12px;
            padding:12px 20px;
            color:rgba(255,255,255,0.6);
            cursor:pointer;
            font-size:14px;
            font-weight:600;
            transition:0.2s;
            border-left:3px solid transparent;
        }
        .nav-item:hover, .nav-item.active {
            color:#fff;
            background:rgba(255,255,255,0.06);
            border-left-color:#1a73e8;
        }
        .nav-item i { width:18px; text-align:center; }
        .sidebar-footer {
            padding:16px 20px;
            border-top:1px solid rgba(255,255,255,0.08);
        }
        .sidebar-footer a {
            display:flex;
            align-items:center;
            gap:10px;
            color:rgba(255,255,255,0.5);
            text-decoration:none;
            font-size:13px;
            font-weight:600;
            transition:0.2s;
        }
        .sidebar-footer a:hover { color:#fff; }

        /* Main */
        .main { margin-left:240px; flex:1; padding:32px; }

        /* Header */
        .page-header {
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:28px;
        }
        .page-header h1 { font-size:22px; font-weight:800; color:#1a1a2e; }
        .page-header h1 span { color:#1a73e8; }
        .page-header small { font-size:13px; color:#aaa; display:block; margin-top:2px; }

        /* Toast */
        .toast {
            position:fixed; top:20px; right:20px;
            background:#fff;
            border-left:4px solid #1a73e8;
            padding:14px 20px;
            border-radius:10px;
            font-weight:600;
            font-size:14px;
            box-shadow:0 6px 20px rgba(0,0,0,0.1);
            z-index:9999;
            animation:slideIn 0.3s ease;
        }
        @keyframes slideIn { from { opacity:0; transform:translateX(40px); } to { opacity:1; transform:translateX(0); } }

        /* Stats Grid */
        .stats-grid {
            display:grid;
            grid-template-columns:repeat(auto-fill, minmax(180px,1fr));
            gap:18px;
            margin-bottom:32px;
        }
        .stat-card {
            background:#fff;
            border-radius:16px;
            padding:22px 20px;
            display:flex;
            align-items:center;
            gap:16px;
            box-shadow:0 4px 14px rgba(0,0,0,0.06);
            border:1px solid #e6eaf0;
        }
        .stat-icon {
            width:48px; height:48px;
            border-radius:12px;
            display:flex; align-items:center; justify-content:center;
            font-size:20px;
            flex-shrink:0;
        }
        .stat-value { font-size:28px; font-weight:800; color:#1a1a2e; line-height:1; }
        .stat-label { font-size:11px; font-weight:700; color:#aaa; text-transform:uppercase; letter-spacing:0.7px; margin-top:4px; }

        /* Section */
        .section { margin-bottom:36px; }
        .section-title {
            font-size:13px;
            font-weight:700;
            letter-spacing:1px;
            text-transform:uppercase;
            color:#aaa;
            margin-bottom:14px;
            display:flex;
            align-items:center;
            gap:8px;
        }

        /* Table */
        .table-wrap {
            background:#fff;
            border-radius:16px;
            box-shadow:0 4px 14px rgba(0,0,0,0.06);
            border:1px solid #e6eaf0;
            overflow:hidden;
        }
        .search-bar {
            padding:14px 20px;
            border-bottom:1px solid #f0f0f0;
        }
        .search-bar input {
            width:100%;
            padding:10px 14px;
            border:1.5px solid #e0e0e0;
            border-radius:10px;
            font-size:14px;
            outline:none;
            transition:0.2s;
        }
        .search-bar input:focus { border-color:#1a73e8; box-shadow:0 0 0 3px rgba(26,115,232,0.1); }
        table { width:100%; border-collapse:collapse; }
        th {
            background:#f8faff;
            padding:12px 16px;
            text-align:left;
            font-size:11px;
            font-weight:700;
            color:#aaa;
            text-transform:uppercase;
            letter-spacing:0.7px;
            border-bottom:1px solid #f0f0f0;
        }
        td {
            padding:13px 16px;
            font-size:14px;
            border-bottom:1px solid #f8f8f8;
            vertical-align:middle;
        }
        tr:last-child td { border-bottom:none; }
        tr:hover td { background:#fafcff; }

        /* Badges */
        .badge {
            display:inline-block;
            padding:3px 10px;
            border-radius:20px;
            font-size:11px;
            font-weight:700;
        }
        .badge-admin    { background:#e3f2fd; color:#1565c0; }
        .badge-user     { background:#f5f5f5; color:#888; }
        .badge-banned   { background:#fde8e8; color:#e74c3c; }
        .badge-active   { background:#e8f5e9; color:#2e7d32; }
        .badge-pending  { background:#fff8e1; color:#f57f17; }

        /* Action buttons */
        .actions { display:flex; gap:6px; flex-wrap:wrap; }
        .btn {
            border:none;
            padding:6px 12px;
            border-radius:8px;
            font-size:12px;
            font-weight:700;
            cursor:pointer;
            transition:0.2s;
            display:inline-flex;
            align-items:center;
            gap:5px;
        }
        .btn:hover { transform:translateY(-1px); }
        .btn-ban     { background:#fde8e8; color:#e74c3c; }
        .btn-unban   { background:#e8f5e9; color:#2e7d32; }
        .btn-delete  { background:#fde8e8; color:#c0392b; }
        .btn-promote { background:#e3f2fd; color:#1565c0; }
        .btn-demote  { background:#fff8e1; color:#f57f17; }

        /* Avatar */
        .user-avatar {
            width:32px; height:32px;
            border-radius:50%;
            background:linear-gradient(135deg,#1a73e8,#4a9eff);
            color:#fff;
            display:inline-flex;
            align-items:center;
            justify-content:center;
            font-size:13px;
            font-weight:700;
            margin-right:8px;
            flex-shrink:0;
        }
        .user-cell { display:flex; align-items:center; }

        /* Tabs */
        .tabs { display:flex; gap:4px; margin-bottom:20px; }
        .tab {
            padding:9px 20px;
            border-radius:10px;
            font-size:13px;
            font-weight:700;
            cursor:pointer;
            color:#888;
            background:#fff;
            border:1.5px solid #e0e0e0;
            transition:0.2s;
        }
        .tab.active { background:#1a73e8; color:#fff; border-color:#1a73e8; }

        .tab-content { display:none; }
        .tab-content.active { display:block; }

        @media(max-width:768px) {
            .sidebar { width:100%; height:auto; position:relative; flex-direction:row; flex-wrap:wrap; }
            .main { margin-left:0; padding:20px; }
            .stats-grid { grid-template-columns:1fr 1fr; }
            .layout { flex-direction:column; }
        }
    </style>
</head>
<body>

<div class="layout">

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-logo">
            <i class="fa-solid fa-shield-halved" style="color:#1a73e8;font-size:20px;"></i>
            <span>SystemVote</span>
            <span class="badge">ADMIN</span>
        </div>
        <nav class="sidebar-nav">
            <div class="nav-item active" onclick="showTab('overview')">
                <i class="fa-solid fa-chart-pie"></i> Overview
            </div>
            <div class="nav-item" onclick="showTab('users')">
                <i class="fa-solid fa-users"></i> Users
            </div>
            <div class="nav-item" onclick="showTab('rooms')">
                <i class="fa-solid fa-door-open"></i> Rooms
            </div>
        </nav>
        <div class="sidebar-footer">
            <a href="/dashboard">
                <i class="fa-solid fa-arrow-left"></i> Back to App
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main">

        @include('components.toast')

        <div class="page-header">
            <div>
                <h1><span>Super</span> Admin Panel</h1>
                <small>Logged in as {{ auth()->user()->name }}</small>
            </div>
        </div>

        <!-- ===== OVERVIEW TAB ===== -->
        <div class="tab-content active" id="tab-overview">

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon" style="background:#e3f2fd;">
                        <i class="fa-solid fa-users" style="color:#1565c0;"></i>
                    </div>
                    <div>
                        <div class="stat-value">{{ $stats['total_users'] }}</div>
                        <div class="stat-label">Total Users</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background:#e8f5e9;">
                        <i class="fa-solid fa-door-open" style="color:#2e7d32;"></i>
                    </div>
                    <div>
                        <div class="stat-value">{{ $stats['total_rooms'] }}</div>
                        <div class="stat-label">Total Rooms</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background:#f3e5f5;">
                        <i class="fa-solid fa-clipboard-list" style="color:#7b1fa2;"></i>
                    </div>
                    <div>
                        <div class="stat-value">{{ $stats['total_topics'] }}</div>
                        <div class="stat-label">Total Topics</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background:#fff8e1;">
                        <i class="fa-solid fa-square-poll-vertical" style="color:#f57f17;"></i>
                    </div>
                    <div>
                        <div class="stat-value">{{ $stats['total_votes'] }}</div>
                        <div class="stat-label">Total Votes</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background:#fde8e8;">
                        <i class="fa-solid fa-ban" style="color:#e74c3c;"></i>
                    </div>
                    <div>
                        <div class="stat-value">{{ $stats['banned_users'] }}</div>
                        <div class="stat-label">Banned Users</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background:#e8f5e9;">
                        <i class="fa-solid fa-circle-play" style="color:#2e7d32;"></i>
                    </div>
                    <div>
                        <div class="stat-value">{{ $stats['active_rooms'] }}</div>
                        <div class="stat-label">Active Rooms</div>
                    </div>
                </div>
            </div>

            <!-- Recent Users -->
            <div class="section">
                <div class="section-title"><i class="fa-solid fa-clock-rotate-left"></i> Recent Users</div>
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Rooms</th>
                                <th>Joined</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users->take(5) as $user)
                            <tr>
                                <td>
                                    <div class="user-cell">
                                        <div class="user-avatar">{{ strtoupper(substr($user->name,0,1)) }}</div>
                                        {{ $user->name }}
                                    </div>
                                </td>
                                <td style="color:#888;">{{ $user->email }}</td>
                                <td>
                                    <span class="badge {{ $user->role === 'superadmin' ? 'badge-admin' : 'badge-user' }}">
                                        {{ $user->role === 'superadmin' ? 'Admin' : 'User' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge {{ $user->is_banned ? 'badge-banned' : 'badge-active' }}">
                                        {{ $user->is_banned ? 'Banned' : 'Active' }}
                                    </span>
                                </td>
                                <td>{{ $user->rooms_count }}</td>
                                <td style="color:#aaa;font-size:12px;">{{ $user->created_at->format('M d, Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <!-- ===== USERS TAB ===== -->
        <div class="tab-content" id="tab-users">
            <div class="section">
                <div class="section-title"><i class="fa-solid fa-users"></i> All Users ({{ $users->count() }})</div>
                <div class="table-wrap">
                    <div class="search-bar">
                        <input type="text" id="userSearch" placeholder="Search users by name or email..." oninput="filterTable('userSearch','usersTable')">
                    </div>
                    <table id="usersTable">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Rooms</th>
                                <th>Joined</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>
                                    <div class="user-cell">
                                        <div class="user-avatar">{{ strtoupper(substr($user->name,0,1)) }}</div>
                                        {{ $user->name }}
                                    </div>
                                </td>
                                <td style="color:#888;">{{ $user->email }}</td>
                                <td>
                                    <span class="badge {{ $user->role === 'superadmin' ? 'badge-admin' : 'badge-user' }}">
                                        {{ $user->role === 'superadmin' ? 'Admin' : 'User' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge {{ $user->is_banned ? 'badge-banned' : 'badge-active' }}">
                                        {{ $user->is_banned ? 'Banned' : 'Active' }}
                                    </span>
                                </td>
                                <td>{{ $user->rooms_count }}</td>
                                <td style="color:#aaa;font-size:12px;">{{ $user->created_at->format('M d, Y') }}</td>
                                <td>
                                    @if($user->id !== auth()->id())
                                    <div class="actions">
                                        @if($user->is_banned)
                                        <form method="POST" action="/superadmin/users/{{ $user->id }}/unban">
                                            @csrf
                                            <button class="btn btn-unban"><i class="fa-solid fa-check"></i> Unban</button>
                                        </form>
                                        @else
                                        <form method="POST" action="/superadmin/users/{{ $user->id }}/ban">
                                            @csrf
                                            <button class="btn btn-ban"><i class="fa-solid fa-ban"></i> Ban</button>
                                        </form>
                                        @endif

                                        @if($user->role !== 'superadmin')
                                        <form method="POST" action="/superadmin/users/{{ $user->id }}/promote">
                                            @csrf
                                            <button class="btn btn-promote"><i class="fa-solid fa-arrow-up"></i> Promote</button>
                                        </form>
                                        @else
                                        <form method="POST" action="/superadmin/users/{{ $user->id }}/demote">
                                            @csrf
                                            <button class="btn btn-demote"><i class="fa-solid fa-arrow-down"></i> Demote</button>
                                        </form>
                                        @endif

                                        <form method="POST" action="/superadmin/users/{{ $user->id }}" onsubmit="return confirm('Delete user {{ $user->name }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-delete"><i class="fa-solid fa-trash"></i></button>
                                        </form>
                                    </div>
                                    @else
                                    <span style="color:#aaa;font-size:12px;">You</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- ===== ROOMS TAB ===== -->
        <div class="tab-content" id="tab-rooms">
            <div class="section">
                <div class="section-title"><i class="fa-solid fa-door-open"></i> All Rooms ({{ $rooms->count() }})</div>
                <div class="table-wrap">
                    <div class="search-bar">
                        <input type="text" id="roomSearch" placeholder="Search rooms by name..." oninput="filterTable('roomSearch','roomsTable')">
                    </div>
                    <table id="roomsTable">
                        <thead>
                            <tr>
                                <th>Room Name</th>
                                <th>Owner</th>
                                <th>Code</th>
                                <th>Status</th>
                                <th>Topics</th>
                                <th>Visibility</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rooms as $room)
                            <tr>
                                <td style="font-weight:700;">{{ $room->name }}</td>
                                <td style="color:#888;">{{ $room->user->name ?? '—' }}</td>
                                <td><code style="background:#f0f4ff;padding:2px 8px;border-radius:6px;font-size:12px;color:#1a73e8;">{{ $room->code }}</code></td>
                                <td>
                                    <span class="badge {{ $room->status === 'started' ? 'badge-active' : 'badge-pending' }}">
                                        {{ ucfirst($room->status) }}
                                    </span>
                                </td>
                                <td>{{ $room->topics_count }}</td>
                                <td>
                                    <span class="badge {{ $room->visibility === 'public' ? 'badge-active' : 'badge-user' }}">
                                        {{ ucfirst($room->visibility) }}
                                    </span>
                                </td>
                                <td style="color:#aaa;font-size:12px;">{{ $room->created_at->format('M d, Y') }}</td>
                                <td>
                                    <div class="actions">
                                        <a href="/show/{{ $room->id }}" class="btn btn-promote" style="text-decoration:none;">
                                            <i class="fa-solid fa-eye"></i> View
                                        </a>
                                        <form method="POST" action="/superadmin/rooms/{{ $room->id }}" onsubmit="return confirm('Delete room {{ $room->name }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-delete"><i class="fa-solid fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </main>
</div>

<script>
    // Tab switching
    function showTab(name) {
        document.querySelectorAll('.tab-content').forEach(function(el) {
            el.classList.remove('active');
        });
        document.querySelectorAll('.nav-item').forEach(function(el) {
            el.classList.remove('active');
        });
        document.getElementById('tab-' + name).classList.add('active');
        event.currentTarget.classList.add('active');
    }

   
    function filterTable(inputId, tableId) {
        var value = document.getElementById(inputId).value.toLowerCase();
        var rows = document.getElementById(tableId).querySelectorAll('tbody tr');
        for (var i = 0; i < rows.length; i++) {
            var text = rows[i].innerText.toLowerCase();
            rows[i].style.display = text.includes(value) ? '' : 'none';
        }
    }

   
    var toast = document.getElementById('toast');
    if (toast) {
        setTimeout(function() { toast.style.opacity = '0'; toast.style.transition = '0.4s'; }, 3000);
    }
</script>

</body>
</html>
