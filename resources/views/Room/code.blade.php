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
  font-family: Segoe UI, sans-serif;
}
body {
  background: #0b0b0f;
  color: #fff;
  overflow-x: hidden;
  min-height: 100vh;
}
.bg-shape {
  position: absolute;
  border-radius: 50%;
  filter: blur(80px);
  opacity: 0.4;
  z-index: 0;
}
.shape1 {
  width: 300px;
  height: 300px;
  background: #ff9f0a;
  top: -80px;
  left: -80px;
}
.shape2 {
  width: 250px;
  height: 250px;
  background: #6c5ce7;
  bottom: -80px;
  right: -80px;
}
.nav {
  height: 65px;
  background: rgba(20, 20, 25, 0.7);
  backdrop-filter: blur(10px);
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 30px;
  border-bottom: 1px solid rgba(255, 255, 255, 0.05);
  position: relative;
  z-index: 10;
}
.nav .logo {
  font-weight: bold;
  font-size: 18px;
  color: #ff9f0a;
}
.nav .links {
  display: flex;
  gap: 25px;
}
.nav a {
  color: #fff;
  text-decoration: none;
  font-size: 14px;
  opacity: 0.7;
  transition: 0.3s;
}
.nav a:hover {
  opacity: 1;
  color: #ff9f0a;
}
.title {
  text-align: center;
  margin-top: 40px;
  font-size: 32px;
  font-weight: bold;
  position: relative;
  z-index: 2;
}
.title span {
  color: #ff9f0a;
}

.main-content-layout {
  display: flex;
  justify-content: center;
  align-items: flex-start;
  padding: 40px 20px;
  position: relative;
  z-index: 2;
}

.center-section {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 25px;
  position: relative;
}

.card {
  background: rgba(255, 255, 255, 0.05);
  backdrop-filter: blur(15px);
  border: 1px solid rgba(255, 255, 255, 0.08);
  padding: 30px;
  border-radius: 20px;
  display: flex;
  gap: 30px;
  align-items: center;
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.6);
}

.code {
  display: flex;
  gap: 10px;
}
.box {
  width: 55px;
  height: 75px;
  background: rgba(0, 0, 0, 0.4);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 28px;
  border-radius: 12px;
  font-weight: bold;
  border: 1px solid rgba(255, 255, 255, 0.1);
}
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
  border: 2px solid rgba(255, 255, 255, 0.1);
}
.qr p {
  font-size: 12px;
  color: #aaa;
  margin-bottom: 8px;
  text-align: center;
}
.copy-box {
  display: flex;
  gap: 8px;
  align-items: center;
  background: rgba(0, 0, 0, 0.25);
  padding: 8px 12px;
  border-radius: 12px;
  border: 1px solid rgba(255, 255, 255, 0.08);
}
.copy-box input {
  background: transparent;
  border: none;
  color: #fff;
  outline: none;
  width: 150px;
  font-size: 12px;
}
.copy-box button {
  background: #ff9f0a;
  border: none;
  padding: 6px 12px;
  border-radius: 8px;
  cursor: pointer;
  font-weight: bold;
  font-size: 12px;
}
.regen {
  background: rgba(108, 92, 231, 0.2);
  border: 1px solid #6c5ce7;
  padding: 10px 14px;
  border-radius: 10px;
  color: #fff;
  cursor: pointer;
  font-size: 13px;
  transition: 0.3s;
}
.regen:hover {
  background: #6c5ce7;
}

/* زر أصغر ومتمركز */
.start-btn {
  background: linear-gradient(135deg, #ff9f0a, #ff6a00);
  border: none;
  padding: 12px 40px;
  font-size: 16px;
  border-radius: 14px;
  cursor: pointer;
  font-weight: bold;
  color: #000;
  box-shadow: 0 8px 20px rgba(255, 159, 10, 0.2);
  transition: 0.3s;
  width: auto; /* يجعل الحجم حسب النص */
  min-width: 200px;
}
.start-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 12px 25px rgba(255, 159, 10, 0.4);
}

.users-card {
  background: rgba(255, 255, 255, 0.03);
  backdrop-filter: blur(15px);
  border: 1px solid rgba(255, 255, 255, 0.08);
  border-radius: 20px;
  width: 260px;
  padding: 20px;
  height: 380px;
  display: flex;
  flex-direction: column;
  position: absolute;
  left: calc(100% + 25px);
  top: 0;
}

.users-card h3 {
  font-size: 16px;
  margin-bottom: 15px;
  color: #ff9f0a;
  display: flex;
  justify-content: space-between;
}
.users-list {
  overflow-y: auto;
  display: flex;
  flex-direction: column;
  gap: 12px;
}
.user-item {
  display: flex;
  align-items: center;
  gap: 12px;
  background: rgba(255, 255, 255, 0.05);
  padding: 8px 12px;
  border-radius: 12px;
}
.user-avatar {
  width: 35px;
  height: 35px;
  background: linear-gradient(135deg, #6c5ce7, #a29bfe);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: bold;
  font-size: 14px;
}
.status-dot {
  width: 8px;
  height: 8px;
  background: #00e676;
  border-radius: 50%;
  margin-left: auto;
  box-shadow: 0 0 10px #00e676;
}

@media (max-width: 1200px) {
  .main-content-layout {
    flex-direction: column;
    align-items: center;
  }
  .users-card {
    position: static;
    width: 100%;
    max-width: 500px;
    height: auto;
    margin-top: 20px;
  }
}

</style>
</head>
<body>
    @include('components.navbar')

<div class="bg-shape shape1"></div>
<div class="bg-shape shape2"></div>
<div class="nav">
    <div class="logo">VoteRoom</div>
    <div class="links"><a href="#">Home</a><a href="#">Rooms</a><a href="#">Join</a></div>
</div>
<div class="title"><span>Join</span> Room</div>

<div class="main-content-layout">
    <div class="center-section">
        <div class="card">
            <div class="code">
                @foreach($codeArray as $c)
                    <div class="box">{{$c}}</div>
                @endforeach
            </div>
            <div class="right">
                <div class="qr">
                    <p>Scan to join instantly</p>
                    @php
                        $fullUrl = url("/join/{$rawCode}");
                        $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . urlencode($fullUrl);
                    @endphp
                    <img src="{{ $qrUrl }}" alt="QR">       
                </div>
                <div class="copy-box">
                    <input id="roomLink" value="{{ $fullUrl }}" readonly>
                    <button onclick="copyLink()">Copy</button>
                </div>
                <button class="regen">Regenerate Code</button>
            </div>
        </div>
        
        <form action="/rooms/{{$room_id}}/join" method="GET">
            <button type="submit" class="start-btn">Start Voting</button>
        </form>

        <div class="users-card">
            <h3>Connected Users <span id="userCount">1</span></h3>
            <div class="users-list">
                <div class="user-item">
                    <div class="user-avatar">Y</div>
                    <div class="user-name">You (Admin)</div>
                    <div class="status-dot"></div>
                </div>
                <div class="user-item" style="opacity: 0.5;">
                    <div class="user-avatar" style="background: #444;">?</div>
                    <div class="user-name">Waiting...</div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function copyLink() {
    const link = document.getElementById('roomLink');
    link.select();
    document.execCommand('copy');
    alert('Link copied!');
}
</script>
</body>
</html>