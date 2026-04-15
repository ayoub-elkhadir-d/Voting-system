<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Join Room</title>

<style>
* { margin:0; padding:0; box-sizing:border-box; font-family:'Segoe UI',sans-serif; }

body { background:#dfdfdf; color:#1a1a2e; min-height:100vh; overflow-x:hidden; }

.title { text-align:center; margin-top:40px; font-size:32px; font-weight:bold; }
.title span { color:#1a73e8; }

.main { display:flex; justify-content:center; margin-top:50px; }

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
            $fullUrl = url("/join/{$rawCode}");
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

    <form action="/rooms/{{$room_id}}/join" method="GET">
      <button type="submit" class="start-btn">Start Voting</button>
    </form>
  </div>
</div>

<script>
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
  document.querySelectorAll('.box.error').forEach(box => box.classList.remove('error'));
}, 1000);
</script>

</body>
</html>
