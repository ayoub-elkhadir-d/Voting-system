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
         .layout {
         display:flex;
         flex:1;
         gap:0;
         height:calc(100vh - 56px);
         }
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
         .dot-user { background:#4caf50; }
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
         .badge-user      { background:#e8f5e9; color:#2e7d32; }
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
         /* User section specific styles */
         .sidebar-nav {
         display: flex;
         border-bottom: 1px solid #f0f0f0;
         margin-bottom: 8px;
         }
         .sidebar-nav-item {
         flex: 1;
         text-align: center;
         padding: 12px 0;
         font-size: 13px;
         font-weight: 700;
         color: #999;
         cursor: pointer;
         transition: all 0.2s;
         border-bottom: 2px solid transparent;
         }
         .sidebar-nav-item.active {
         color: #1a73e8;
         border-bottom-color: #1a73e8;
         }
         .sidebar-nav-item:hover {
         color: #1a73e8;
         background: #f5f9ff;
         }
         .sidebar-content-section {
         display: none;
         }
         .sidebar-content-section.active {
         display: block;
         }
         .user-avatar {
         width: 28px;
         height: 28px;
         border-radius: 50%;
         background: linear-gradient(135deg, #1a73e8, #4a9eff);
         color: white;
         display: flex;
         align-items: center;
         justify-content: center;
         font-size: 12px;
         font-weight: 700;
         flex-shrink: 0;
         }
         .user-info {
         display: flex;
         flex-direction: column;
         flex: 1;
         min-width: 0;
         }
         .user-name {
         font-size: 13px;
         font-weight: 600;
         color: #1a1a2e;
         white-space: nowrap;
         overflow: hidden;
         text-overflow: ellipsis;
         }
         .user-email {
         font-size: 11px;
         color: #999;
         white-space: nowrap;
         overflow: hidden;
         text-overflow: ellipsis;
         }
         .user-count {
         background: #e3f2fd;
         color: #1565c0;
         padding: 2px 8px;
         border-radius: 20px;
         font-size: 11px;
         font-weight: 700;
         margin-left: 8px;
         }
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
         .section-label {
         font-size:12px;
         font-weight:700;
         letter-spacing:1px;
         text-transform:uppercase;
         color:#aaa;
         margin:28px 0 12px;
         }
         .topic-card {
         background:#fff;
         border-radius:24px;
         padding:32px 36px;
         margin-bottom:20px;
         box-shadow:0 8px 28px rgba(0,0,0,0.08);
         border:1px solid #e6eaf0;
         }
         .topic-card.active-card {
         border:2px solid #1a73e8;
         box-shadow:0 12px 32px rgba(26,115,232,0.16);
         background: linear-gradient(135deg, #ffffff 0%, #fafcff 100%);
         }
         .topic-header {
         display:flex;
         justify-content:space-between;
         align-items:center;
         margin-bottom:28px;
         flex-wrap:wrap;
         gap:12px;
         }
         .topic-name { 
         font-size:28px; 
         font-weight:800; 
         background: linear-gradient(135deg, #1a2a4f, #1a73e8);
         background-clip: text;
         -webkit-background-clip: text;
         color: transparent;
         letter-spacing:-0.3px;
         }
         .badge-completed {
         background:#e8f5e9;
         color:#2e7d32;
         padding:6px 16px;
         border-radius:40px;
         font-size:13px;
         font-weight:700;
         }
         .badge-active {
         background:#e3f2fd;
         color:#1565c0;
         padding:6px 18px;
         border-radius:40px;
         font-size:13px;
         font-weight:700;
         animation:pulse 1.5s infinite;
         }
         .choice-row {
         display:flex;
         align-items:center;
         gap:16px;
         margin-bottom:14px;
         }
         .choice-label { 
         width:160px; 
         font-size:15px; 
         font-weight:700; 
         flex-shrink:0;
         color:#2c3e66;
         }
         .bar-wrap {
         flex:1;
         background:#f0f4fc;
         border-radius:12px;
         height:28px;
         overflow:hidden;
         }
         .bar-fill {
         height:100%;
         background:linear-gradient(90deg, #1a73e8, #4a9eff);
         border-radius:12px;
         transition:width 0.5s cubic-bezier(0.2, 0.9, 0.4, 1.1);
         min-width:4px;
         box-shadow:0 1px 2px rgba(0,0,0,0.05);
         }
         .vote-count {
         width:80px;
         text-align:right;
         font-size:16px;
         font-weight:800;
         color:#1e293b;
         font-feature-settings: "tnum";
         }
         .stop-btn {
         margin-top:32px;
         background:#e74c3c;
         color:#fff;
         border:none;
         padding:12px 36px;
         border-radius:60px;
         font-weight:800;
         font-size:15px;
         cursor:pointer;
         transition:0.2s;
         letter-spacing:0.5px;
         }
         .stop-btn:hover { background:#c0392b; transform:translateY(-2px); box-shadow:0 6px 14px rgba(231,76,60,0.3); }
         .next-btn {
         margin-top:22px;
         margin-left:12px;
         background:#1a73e8;
         color:#fff;
         border:none;
         padding:12px 36px;
         border-radius:60px;
         font-weight:800;
         font-size:15px;
         cursor:pointer;
         transition:0.2s;
         }
         .next-btn:hover { background:#1558b0; transform:translateY(-2px); }
         .empty-state {
         text-align:center;
         color:#bbb;
         padding:60px 0;
         font-size:15px;
         }
         .topic-center-card {
         background: #ffffff;
         border-radius: 32px;
         padding: 28px 36px;
         margin-bottom: 28px;
         box-shadow: 0 12px 28px rgba(0,0,0,0.08);
         transition: all 0.2s;
         position: relative;
         }
         .topic-name-large {
         font-size: 36px;
         font-weight: 800;
         text-align: center;
         background: linear-gradient(115deg, #0f2b4d, #1a73e8);
         background-clip: text;
         -webkit-background-clip: text;
         color: transparent;
         letter-spacing: -0.5px;
         margin: 12px 0 8px;
         word-break: break-word;
         line-height: 1.2;
         }
         .live-chip {
         display: inline-flex;
         align-items: center;
         gap: 8px;
         background: #eef3fc;
         border-radius: 100px;
         padding: 6px 20px;
         font-size: 13px;
         font-weight: 700;
         color: #1a73e8;
         }
         .live-dot {
         width: 10px;
         height: 10px;
         background: #FF0000;
         border-radius: 50%;
         animation: pulse 1.2s infinite;
         }
         .choice-section-title {
         font-size: 14px;
         font-weight: 700;
         color: #6c86a3;
         letter-spacing: 1px;
         margin: 28px 0 16px 0;
         text-transform: uppercase;
         border-left: 4px solid #1a73e8;
         padding-left: 14px;
         }
         .choices-container {
         margin-top: 6px;
         }
         .action-buttons {
         display: flex;
         gap: 16px;
         justify-content: flex-start;
         margin-top: 32px;
         }
         /* new compact timer - right aligned, smaller, prominent color */
         .compact-timer-wrapper {
         position: absolute;
         top: 28px;
         right: 36px;
         z-index: 5;
         }
         .compact-timer-card {
         background: linear-gradient(145deg, #fff0e6, #ffe6d5);
         border-radius: 60px;
         padding: 8px 20px;
         box-shadow: 0 6px 14px rgba(255, 87, 34, 0.25);
         border: 1px solid rgba(255, 87, 34, 0.4);
         display: flex;
         align-items: baseline;
         gap: 12px;
         backdrop-filter: blur(2px);
         transition: all 0.2s;
         }
         .timer-label-compact {
         font-size: 11px;
         font-weight: 800;
         letter-spacing: 1px;
         color: #e65100;
         text-transform: uppercase;
         background: rgba(255,255,200,0.5);
         padding: 2px 8px;
         border-radius: 30px;
         }
         .timer-digits-compact {
         font-family: 'SF Mono', 'Fira Code', monospace;
         font-size: 22px;
         font-weight: 800;
         color: #d84315;
         letter-spacing: 1px;
         background: rgba(255,255,245,0.9);
         padding: 2px 12px;
         border-radius: 40px;
         box-shadow: inset 0 1px 2px rgba(0,0,0,0.02), 0 1px 2px rgba(0,0,0,0.05);
         }
         .warning-timer {
         background: linear-gradient(145deg, #ffded5, #ffc8b8);
         border-color: #ff5722;
         box-shadow: 0 6px 14px rgba(255, 87, 34, 0.45);
         }
         .warning-timer .timer-digits-compact {
         color: #bf360c;
         text-shadow: 0 0 4px rgba(255,60,0,0.3);
         }
         .remove-btn {
         background:#ffeaea;
         border:none;
         color:#e74c3c;
         width:26px;
         height:26px;
         border-radius:50%;
         font-size:14px;
         font-weight:bold;
         cursor:pointer;
         display:flex;
         align-items:center;
         justify-content:center;
         transition:0.2s;
         }
         .remove-btn:hover {
         background:#e74c3c;
         color:#fff;
         transform:scale(1.1);
         }
         @media (max-width: 680px) {
         .main { padding: 20px; }
         .topic-name-large { font-size: 26px; }
         .compact-timer-wrapper { position: relative; top: 0; right: 0; display: flex; justify-content: flex-end; margin-bottom: 16px; }
         .topic-center-card { padding-top: 20px; }
         .choice-label { width: 120px; font-size: 13px; }
         .compact-timer-card { padding: 5px 14px; }
         .timer-digits-compact { font-size: 18px; }
         }
      </style>
      @livewireStyles
   </head>
   <body>
      @include('components.navbar')
      <div class="layout">
         <aside class="sidebar">
            <div class="sidebar-header">
               <div class="sidebar-title">Room</div>
               <div class="room-name">{{ $room->name }}</div>
            </div>
            <!-- Navigation Tabs -->
            <div class="sidebar-nav">
               <div class="sidebar-nav-item active" data-tab="topics">
                  Topics
               </div>
               <div class="sidebar-nav-item" data-tab="users">
                  Users 
                  @if(isset($members))
                  <span class="user-count">{{ count($members) }}</span>
                  @endif
               </div>
            </div>
            <!-- Topics Content -->
            <div class="sidebar-content-section active" id="topics-section">
               @livewire('sidebar-topics', ['roomId' => $room->id])
            </div>
            <!-- Users Content -->


           <div class="sidebar-content-section" id="users-section">
                 @livewire('room-users', ['roomId' => $room->id])
           </div>
        


         </aside>
         <main class="main">
            <div class="main-title">Admin — <span>{{ $room->name }}</span></div>
            <div class="section-label">Currently Voting</div>
            @if($active)
            @php $totalVotes = $active->choix->sum('vote_count'); @endphp
            <div class="topic-center-card" id="activeCard" style="position: relative;">
               <div class="compact-timer-wrapper">
                  <div class="compact-timer-card" id="compactTimerCard">
                     <span id="compactTimerDigits" class="timer-digits-compact">00:00</span>
                  </div>
               </div>
               <div class="topic-name-large">{{ $active->name }}</div>
               <div class="choice-section-title"> Vote results</div>
               <div class="choices-container">
                  @foreach($active->choix as $choice)
                  @php $pct = $totalVotes > 0 ? round($choice->vote_count / $totalVotes * 100) : 0; @endphp
                  <div class="choice-row" data-choice-id="{{ $choice->id }}">
                     <div class="choice-label">{{ $choice->name }}</div>
                     <div class="bar-wrap">
                        <div class="bar-fill" style="width:{{ $pct }}%"></div>
                     </div>
                     <div class="vote-count">
                        <span class="count-val">{{ $choice->vote_count }}</span>
                        <span style="font-size:12px; color:#7c8ea0;"> ({{ $pct }}%)</span>
                     </div>
                  </div>
                  @endforeach
               </div>
               <div class="action-buttons">
                  <form action="/rooms/{{ $room->id }}/topic/{{ $active->id }}/stop" method="POST">
                     @csrf
                     <button type="submit" class="stop-btn"> Stop Voting</button>
                  </form>
               </div>
            </div>
            @else
            <div class="empty-state">
               No topic is currently being voted on.
               @if($pending->isNotEmpty())
               <form action="/rooms/{{ $room->id }}/topic/{{ $pending->first()->id }}/start" method="POST" style="margin-top:20px">
                  @csrf
                  <button type="submit" class="next-btn">  Start Next Topic</button>
               </form>
               @else
               <br>Start one from the sidebar.
               @endif
            </div>
            @endif
            @if($completed->isNotEmpty())
            <div class="section-label"> Completed Topics</div>
            @foreach($completed as $topic)
            @php $totalVotes = $topic->choix->sum('vote_count'); @endphp
            <div class="topic-card">
               <div class="topic-header">
                  <div class="topic-name" style="font-size:20px; background:none; color:#1f3a6b;">
                     {{ $topic->name }}
                  </div>
                  <div style="display:flex; gap:10px; align-items:center;">
                     <span class="badge-completed">✓ Completed</span>
                     <!-- Restart Button -->
                     <button
                        onclick="Livewire.dispatch('restart-topic', { topicId: {{ $topic->id }} })"
                        style="
                           background:#f39c12;
                           border:none;
                           padding:6px 14px;
                           border-radius:20px;
                           color:#fff;
                           font-size:12px;
                           font-weight:700;
                           cursor:pointer;
                           ">
                        ↺ Restart
                     </button>
                  </div>
               </div>
               @foreach($topic->choix as $choice)
               @php $pct = $totalVotes > 0 ? round($choice->vote_count / $totalVotes * 100) : 0; @endphp
               <div class="choice-row">
                  <div class="choice-label">{{ $choice->name }}</div>
                  <div class="bar-wrap">
                     <div class="bar-fill" style="width:{{ $pct }}%; background:#9aaebf;"></div>
                  </div>
                  <div class="vote-count">
                     {{ $choice->vote_count }}
                     <small style="color:#8895aa;">({{ $pct }}%)</small>
                  </div>
               </div>
               @endforeach
            </div>
            @endforeach
            @endif
         </main>
      </div>
      <!-- Tab Switching Script -->
      <script>
         document.addEventListener('DOMContentLoaded', function() {
             const navItems = document.querySelectorAll('.sidebar-nav-item');
             const sections = {
                 topics: document.getElementById('topics-section'),
                 users: document.getElementById('users-section')
             };
         
             navItems.forEach(item => {
                 item.addEventListener('click', function(e) {
                     const tab = this.dataset.tab;
                     
                     navItems.forEach(nav => nav.classList.remove('active'));
                     this.classList.add('active');
                     
                     
                     Object.keys(sections).forEach(key => {
                         if (sections[key]) {
                             sections[key].classList.remove('active');
                         }
                     });
                     
                     if (sections[tab]) {
                         sections[tab].classList.add('active');
                     }
                 });
             });
         });
      </script>
      <script>
         document.addEventListener('DOMContentLoaded', function () {
         
             const roomId = {{ $room->id }};
         
             const navItems = document.querySelectorAll('.sidebar-nav-item');
             const sections = {
                 topics: document.getElementById('topics-section'),
                 users: document.getElementById('users-section')
             };
         
         
             navItems.forEach(item => {
                 item.addEventListener('click', function () {
                     const tab = this.dataset.tab;
         
                     // save tab
                     localStorage.setItem('activeTab', tab);
         
                     navItems.forEach(nav => nav.classList.remove('active'));
                     this.classList.add('active');
         
                     Object.keys(sections).forEach(key => {
                         if (sections[key]) sections[key].classList.remove('active');
                     });
         
                     if (sections[tab]) sections[tab].classList.add('active');
                 });
             });
         
         
             const savedTab = localStorage.getItem('activeTab');
         
             if (savedTab && sections[savedTab]) {
         
                 navItems.forEach(nav => nav.classList.remove('active'));
         
                 const activeNav = document.querySelector(`[data-tab="${savedTab}"]`);
                 if (activeNav) activeNav.classList.add('active');
         
                 Object.keys(sections).forEach(key => {
                     if (sections[key]) sections[key].classList.remove('active');
                 });
         
                 sections[savedTab].classList.add('active');
             }
         
             function initEcho() {
                 if (typeof Echo === 'undefined') {
                     setTimeout(initEcho, 100);
                     return;
                 }
         
                 Echo.channel('room.' + roomId)
         
                 
                     .listen('.user.joined', function () {
                      
                         const active = document.querySelector('.sidebar-nav-item.active');
                         if (active) {
                             localStorage.setItem('activeTab', active.dataset.tab);
                         }
                         Livewire.dispatch('refreshUsers');
         
                         {{-- window.location.reload(); --}}

                     })
         
                 
                     .listen('.vote.updated', function (e) {
                         if (typeof updateVotes === 'function') {
                             updateVotes(e.choices);
                         }
                     })
         
                    
                     .listen('.topic.started', function () {
                         window.location.reload();
                     })
                     .listen('.topic.ended', function () {
                         window.location.reload();
                     })
                     .listen('.user.left', (e) => {
              
                         location.reload();
                     });
             }
         
             initEcho();
         
          
             @if($active)
         
             const activeTopicId = {{ $active->id }};
             const activeDuration = @json($active->duration);
             const startedAt = {{ strtotime($active->started_at) }};
         
             let interval = null;
             let timeout = null;
         
             function toSeconds(t) {
                 let p = t.split(':');
                 return (+p[0]) * 3600 + (+p[1]) * 60 + (+p[2]);
             }
         
             function format(s) {
                 let m = Math.floor(s / 60);
                 let sec = s % 60;
         
                 if (m < 10) m = '0' + m;
                 if (sec < 10) sec = '0' + sec;
         
                 return m + ':' + sec;
             }
         
             function updateVotes(data) {
                 let total = 0;
         
                 data.forEach(i => total += i.votes);
         
                 data.forEach(item => {
                     let row = document.querySelector('[data-choice-id="' + item.id + '"]');
                     if (!row) return;
         
                     let percent = total > 0 ? Math.round((item.votes / total) * 100) : 0;
         
                     let fill = row.querySelector('.bar-fill');
                     let count = row.querySelector('.count-val');
         
                     if (fill) fill.style.width = percent + '%';
                     if (count) count.innerText = item.votes;
                 });
             }
         
             function startTimer() {
                 let total = toSeconds(activeDuration);
                 let now = Math.floor(Date.now() / 1000);
                 let remaining = total - (now - startedAt);
         
                 if (remaining < 0) remaining = 0;
         
                 let span = document.getElementById('compactTimerDigits');
                 let card = document.getElementById('compactTimerCard');
         
                 if (!span) return;
         
                 clearInterval(interval);
                 clearTimeout(timeout);
         
                 span.innerText = format(remaining);
         
                 interval = setInterval(() => {
                     remaining--;
         
                     if (remaining < 0) {
                         clearInterval(interval);
                         return;
                     }
         
                     span.innerText = format(remaining);
         
                     if (remaining <= 5) {
                         card.classList.add('warning-timer');
                     }
         
                 }, 1000);
         
                 timeout = setTimeout(() => {
                     fetch('/rooms/' + roomId + '/topic/' + activeTopicId + '/stop', {
                         method: 'POST',
                         headers: {
                             'X-CSRF-TOKEN': '{{ csrf_token() }}'
                         }
                     });
                 }, remaining * 1000);
             }
         
             startTimer();
         
             @endif
         
         });
      </script>
      @livewireScripts
   </body>
</html>