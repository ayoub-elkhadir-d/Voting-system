<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Join Room</title>

<style>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Segoe UI', sans-serif;
}

body {
  background: #0b0b0f;
  color: #fff;
  min-height: 100vh;
  overflow-x: hidden;
}

/* Background Decor */
.bg-shape {
  position: absolute;
  border-radius: 50%;
  filter: blur(80px);
  opacity: 0.4;
  z-index: -1;
}
.shape1 { width:300px; height:300px; background:#ff9f0a; top:-80px; left:-80px; }
.shape2 { width:250px; height:250px; background:#6c5ce7; bottom:-80px; right:-80px; }

.title {
  text-align: center;
  margin-top: 40px;
  font-size: 32px;
  font-weight: bold;
}
.title span { color:#ff9f0a; }

/* Layout */
.main {
  display: flex;
  justify-content: center;
  margin-top: 50px;
}

/* Card */
.card {
  background: rgba(255,255,255,0.05);
  backdrop-filter: blur(15px);
  padding: 30px;
  border-radius: 20px;
  display: flex;
  gap: 30px;
  align-items: center;
  box-shadow: 0 20px 60px rgba(0,0,0,0.6);
}

/* Code Boxes */
.code {
  display: flex;
  gap: 10px;
}

.box {
  width: 55px;
  height: 75px;
  background: rgba(0,0,0,0.4);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 28px;
  border-radius: 12px;
  font-weight: bold;
  border: 1px solid rgba(255,255,255,0.1);
  transition: all 0.5s ease;
  cursor: pointer;
}

/* ERROR STYLE */
.box.error {
  border: 1px solid #ff4d4f;
  box-shadow: 0 0 10px rgba(255,77,79,0.6);
  animation: shake 0.3s;
}

.input-error {
  color: #ff4d4f;
  font-size: 13px;
  margin-top: 12px;
  text-align: center;
  animation: fadeIn 0.3s ease;
  transition: opacity 0.5s ease; /* Smooth fade out */
}

/* Animations */
@keyframes shake {
  0% { transform: translateX(0); }
  25% { transform: translateX(-6px); }
  50% { transform: translateX(6px); }
  75% { transform: translateX(-6px); }
  100% { transform: translateX(0); }
}

@keyframes fadeIn {
  from { opacity:0; transform:translateY(-5px); }
  to { opacity:1; transform:translateY(0); }
}

/* Right side */
.right {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 15px;
}

.qr img {
  width: 140px;
  height: 140px;
  border-radius: 12px;
}

.copy-box {
  display: flex;
  gap: 8px;
  background: rgba(0,0,0,0.3);
  padding: 8px 12px;
  border-radius: 10px;
}

.copy-box input {
  background: transparent;
  border: none;
  color: #fff;
  width: 150px;
  outline: none;
}

.copy-box button {
  background: #ff9f0a;
  border: none;
  padding: 6px 12px;
  border-radius: 8px;
  cursor: pointer;
  font-weight: 600;
  transition: 0.2s;
}

.copy-box button:active { transform: scale(0.95); }

/* Button */
.start-btn {
  display: block;
  width: fit-content;
  margin: 25px auto 0;
  background: linear-gradient(135deg,#ff9f0a,#ff6a00);
  border: none;
  padding: 12px 40px;
  border-radius: 14px;
  font-weight: bold;
  color: white;
  cursor: pointer;
  transition: 0.3s;
}

.start-btn:hover { opacity: 0.9; transform: translateY(-2px); }

</style>
</head>

<body>

<div class="bg-shape shape1"></div>
<div class="bg-shape shape2"></div>

<div class="title"><span>Join</span> Room</div>

<div class="main">
  <div>
    
    <div class="card">
      
      <div>
        <div class="code" id="codeBoxes">
          @foreach($codeArray as $c)
            <div class="box {{ session('error') ? 'error' : '' }}" data-digit="{{$c}}">
              {{$c}}
            </div>
          @endforeach
        </div>

        @if (session('error'))
          <div class="input-error" id="errorMsg">
            {{ session('error') }}
          </div>
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
  
  // Optional: change button text briefly
  const btn = event.target;
  const originalText = btn.innerText;
  btn.innerText = "Copied!";
  setTimeout(() => btn.innerText = originalText, 2000);
}

setTimeout(() => {
  const errText = document.getElementById('errorMsg');
  if (errText) {
    errText.style.opacity = "0";
  }

  const errorBoxes = document.querySelectorAll('.box.error');
  errorBoxes.forEach(box => {
    box.classList.remove('error');
  });
}, 1000);
</script>

</body>
</html>