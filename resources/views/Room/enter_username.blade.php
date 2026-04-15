<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Join Room</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Segoe UI, sans-serif;
}

body{
    background:#0b0b0f;
    color:#fff;
    overflow-x:hidden;
}

.bg-shape{
    position:absolute;
    border-radius:50%;
    filter: blur(80px);
    opacity:0.4;
    z-index:0;
}

.shape1{
    width:300px;
    height:300px;
    background:#ff9f0a;
    top:-80px;
    left:-80px;
}

.shape2{
    width:250px;
    height:250px;
    background:#6c5ce7;
    bottom:-80px;
    right:-80px;
}

/* NAV */
.nav{
    height:65px;
    background:rgba(20,20,25,0.7);
    backdrop-filter: blur(10px);
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:0 30px;
    border-bottom:1px solid rgba(255,255,255,0.05);
    position:relative;
    z-index:2;
}

.nav .logo{
    font-weight:bold;
    font-size:18px;
    color:#ff9f0a;
}

/* TITLE */
.title{
    text-align:center;
    margin-top:50px;
    font-size:32px;
    font-weight:bold;
    position:relative;
    z-index:2;
}

.title span{
    color:#ff9f0a;
}

/* CONTAINER */
.container{
    display:flex;
    justify-content:center;
    margin-top:60px;
    position:relative;
    z-index:2;
}

/* CARD */
.card{
    background:rgba(255,255,255,0.05);
    backdrop-filter: blur(15px);
    border:1px solid rgba(255,255,255,0.08);
    padding:40px;
    border-radius:20px;
    display:flex;
    flex-direction:column;
    align-items:center;
    gap:15px;
    box-shadow:0 20px 60px rgba(0,0,0,0.6);
}

/* INPUT */
.card input{
    width:280px;
    height:70px;
    font-size:20px;
    text-align:center;
    border-radius:12px;
    border:1px solid rgba(255,255,255,0.15);
    background:rgba(0,0,0,0.4);
    color:#fff;
    outline:none;
    transition:0.3s;
}

.card input:focus{
    border-color:#ff9f0a;
    transform:scale(1.05);
}

/* PLACEHOLDER */
input::placeholder{
    font-size:18px;
    color:rgba(255,255,255,0.35);

}

/* BUTTON JOIN */
.join-btn{
    background:linear-gradient(135deg,#ff9f0a,#ff6a00);
    border:none;
    padding:14px 50px;
    font-size:18px;
    border-radius:14px;
    cursor:pointer;
    font-weight:bold;
    color:#000;
    box-shadow:0 15px 40px rgba(255,159,10,0.4);
    transition:0.3s;
}

.join-btn:hover{
    transform:scale(1.07);
}

/* RANDOM BUTTON */
.random-btn{
    background:transparent;
    border:1px solid rgba(255,255,255,0.2);
    color:#fff;
    padding:10px 20px;
    border-radius:12px;
    cursor:pointer;
    transition:0.3s;
}

.random-btn:hover{
    background:rgba(255,255,255,0.08);
    transform:scale(1.05);
}

/* ERROR */
.alert-success{
    position:fixed;
    top:20px;
    right:20px;
    background:#00e676;
    color:#000;
    padding:12px 16px;
    border-radius:10px;
    z-index:99999;
}
</style>
</head>

<body>

@include('components.navbar')

@if (session('success'))
<div class="alert-success">{{ session('success') }}</div>
@endif

<div class="bg-shape shape1"></div>
<div class="bg-shape shape2"></div>

<div class="title">
    <span>Join</span> Room
</div>

<div class="container">

<form method="POST" action="/rooms/confirm-join"> @csrf
    <div class="card">
        @if(session('error'))
            <div style="background:#d32f2f;color:#fff;padding:10px 15px;border-radius:10px;">
                {{ session('error') }}
            </div>
        @endif

        <input type="hidden" name="room_id" value="{{ $room_id }}">

        <input name="user_name" type="text" placeholder="Type your username..." required>
       @error('user_name')
    <div style="color: #ff6a00; font-size: 13px; font-weight: bold;">
        {{ $message }}
    </div>
@enderror
        <button type="button" class="random-btn" onclick="generateUsername()">
            Random Username
        </button>

        <button class="join-btn" type="submit">Join Room</button>
    </div>
</form>

</div>

<script>
function generateUsername() {
    const adjectives = ["Dark","Fast","Crazy","Silent","Happy","Fire","Blue","Ultra","Ghost","Mega"];
    const nouns = ["Tiger","Wolf","Ninja","Coder","Dragon","Player","King","Shadow","Hunter","Fox"];

    const name =
        adjectives[Math.floor(Math.random() * adjectives.length)] +
        nouns[Math.floor(Math.random() * nouns.length)] +
        Math.floor(Math.random() * 9999);

    document.querySelector('input[name="user_name"]').value = name;
}
</script>

</body>
</html>