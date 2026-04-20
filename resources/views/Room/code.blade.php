<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite(['resources/js/app.js'])
<title>Join Room</title>

<style>
* { margin:0; padding:0; box-sizing:border-box; font-family:'Segoe UI',sans-serif; }

body { background:#dfdfdf; color:#1a1a2e; min-height:100vh; overflow-x:hidden; }

.title { text-align:center; margin-top:40px; font-size:32px; font-weight:bold; }
.title span { color:#1a73e8; }

.main { display:flex; justify-content:center; gap: 30px; margin-top:50px; flex-wrap: wrap; }

.activity-card {
  background:#fff;
  padding:30px;
  border-radius:20px;
  width: 320px;
  box-shadow:0 8px 32px rgba(0,0,0,0.08);
  border:1px solid #e0e0e0;
}

.activity-card h3 { color: #1a73e8; margin-bottom: 15px; font-size: 18px; }
.log-list { list-style: none; max-height: 200px; overflow-y: auto; }
.log-item { padding: 8px 0; border-bottom: 1px solid #f0f0f0; font-size: 14px; display: flex; justify-content: space-between; }
.log-time { color: #888; font-size: 12px; }
.card {
  background:#fff;
  padding:30px;
  border-radius:20px;
  display:flex;
  gap:30px;
  align-items:center;
  box-shadow:0 8px 32px rgba(0,0,0,0.08);
  border:1px solid #e0e0e0;
}

.code { display:flex; gap:10px; }

.box {
  width:55px; height:75px;
  background:#dfdfdf;
  display:flex;
  align-items:center;
  justify-content:center;
  font-size:28px;
  border-radius:12px;
  font-weight:bold;
  color:#1a73e8;
  border:1px solid #e0e0e0;
  transition:all 0.5s ease;
  cursor:pointer;
}

.box.error {
  border:1px solid #e74c3c;
  box-shadow:0 0 10px rgba(231,76,60,0.3);
  animation:shake 0.3s;
}

.input-error {
  color:#e74c3c;
  font-size:13px;
  margin-top:12px;
  text-align:center;
  animation:fadeIn 0.3s ease;
}

@keyframes shake {
  0%{transform:translateX(0);} 25%{transform:translateX(-6px);}
  50%{transform:translateX(6px);} 75%{transform:translateX(-6px);}
  100%{transform:translateX(0);}
}

@keyframes fadeIn {
  from{opacity:0;transform:translateY(-5px);}
  to{opacity:1;transform:translateY(0);}
}

.right { display:flex; flex-direction:column; align-items:center; gap:15px; }

.qr img { width:140px; height:140px; border-radius:12px; border:3px solid #e0e0e0; }

.copy-box {
  display:flex; gap:8px;
  background:#dfdfdf;
  padding:8px 12px;
  border-radius:10px;
  border:1px solid #e0e0e0;
}

.copy-box input { background:transparent; border:none; color:#1a1a2e; width:150px; outline:none; }

.copy-box button {
  background:#1a73e8;
  border:none;
  padding:6px 12px;
  border-radius:8px;
  cursor:pointer;
  color:#fff;
  font-weight:600;
  transition:0.2s;
}

.copy-box button:active { transform:scale(0.95); }

.start-btn {
  display:block;
  width:fit-content;
  margin:25px auto 0;
  background:#1a73e8;
  border:none;
  padding:12px 40px;
  border-radius:14px;
  font-weight:bold;
  color:#fff;
  cursor:pointer;
  transition:0.3s;
  box-shadow:0 4px 15px rgba(26,115,232,0.25);
}

.start-btn:hover { background:#1558b0; transform:translateY(-2px); box-shadow:0 6px 20px rgba(26,115,232,0.35); }
</style>
</head>

<body>
@include('components.navbar')

<div class="title"><span>Join</span> Room</div>

<div class="main">
  <div>
    <div class="card">
      <div>
        <div class="code" id="codeBoxes">
          @foreach($codeArray as $c)
            <div class="box {{ session('error') ? 'error' : '' }}" data-digit="{{$c}}">{{$c}}</div>
          @endforeach
        </div>

        @if (session('error'))
          <div class="input-error" id="errorMsg">{{ session('error') }}</div>
        @endif
      </div>

      <div class="right">
        <div class="qr">
          @php
            $fullUrl = url("/rooms/join/{$rawCode}");
            $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . urlencode($fullUrl);
          @endphp
          <img src="{{ $qrUrl }}" alt="QR Code">
        </div>

        <div class="copy-box">
          <input id="roomLink" value="{{ $fullUrl }}" readonly>
          <button onclick="copyLink()">Copy</button>
        </div>
      </div>
    </div>

  <form action="/rooms/{{ $room_id }}/start" method="POST">
    @csrf
    <button type="submit" class="start-btn">▶ Start Voting</button>
</form>
  </div>
  <div class="activity-card">
    <h3>Room Activity</h3>
        <ul class="log-list" id="logList">
@foreach($members as $m)
    <li class="log-item" style="align-items:center; gap:10px;">
        
        <span>
            {{ $m->username }}
            
            @if($m->status === 'pending')
                <span style="color:#f39c12;">(pending)</span>
            @else
                joined
            @endif
        </span>

        <span class="log-time">
            {{ \Carbon\Carbon::parse($m->created_at)->format('H:i') }}
        </span>

        
        @if($room->visibility === 'private' && $m->status === 'pending')
            <div style="display:flex; gap:6px; margin-left:auto;">

                {{-- Accept --}}
                <form action="/rooms/{{ $room->id }}/approve/{{ $m->id }}" method="POST">
                    @csrf
                    <button style="
                        background:#2ecc71;
                        border:none;
                        padding:4px 10px;
                        border-radius:6px;
                        color:#fff;
                        font-size:11px;
                        cursor:pointer;
                    ">✔</button>
                </form>

                {{-- Decline --}}
                <form action="/rooms/{{ $room->id }}/remove/{{ $m->id }}" method="POST">
                    @csrf
                    <button style="
                        background:#e74c3c;
                        border:none;
                        padding:4px 10px;
                        border-radius:6px;
                        color:#fff;
                        font-size:11px;
                        cursor:pointer;
                    ">✖</button>
                </form>

            </div>
        @endif

    </li>
@endforeach
    </ul>
  </div>
</div>

<script>
window.addEventListener('DOMContentLoaded', () => {
    let roomId = "{{ $room_id }}";
    let totalElement = document.getElementById('total');
    let logList = document.getElementById('logList');

  
    if (roomId && typeof Echo !== 'undefined') {

        Echo.channel('room.' + roomId)

           
            .listen('.user.joined', (e) => {
                
                window.location.reload();
                
                let logList = document.getElementById('logList');

                let li = document.createElement('li');
                li.classList.add('log-item');

                let nameSpan = document.createElement('span');
                nameSpan.innerText = e.username + ' joined';

                let timeSpan = document.createElement('span');
                timeSpan.classList.add('log-time');

                let now = new Date();
                let time = now.getHours().toString().padStart(2, '0') + ':' +
                           now.getMinutes().toString().padStart(2, '0');

                timeSpan.innerText = time;

                li.appendChild(nameSpan);
                li.appendChild(timeSpan);

                logList.prepend(li);
            })   
            .listen('.user.left', (e) => {
     
                location.reload();
            });

           

    } else {
        console.log('Echo not ready or roomId missing');
    }
});



function copyLink() {
    const link = document.getElementById('roomLink');
    link.select();
    document.execCommand('copy');

    const btn = event.target;
    const originalText = btn.innerText;

    btn.innerText = "Copied!";
    setTimeout(() => btn.innerText = originalText, 2000);
}

setTimeout(() => {
    const errText = document.getElementById('errorMsg');
    if (errText) errText.style.opacity = "0";

    document.querySelectorAll('.box.error')
        .forEach(box => box.classList.remove('error'));
}, 1000);
</script>

</body>
</html>
