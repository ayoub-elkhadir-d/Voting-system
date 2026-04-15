<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Join Room</title>

<style>
*{ margin:0; padding:0; box-sizing:border-box; font-family:'Segoe UI',sans-serif; }
body{ background:#dfdfdf; color:#1a1a2e; overflow-x:hidden; }

.title{ text-align:center; margin-top:50px; font-size:32px; font-weight:bold; position:relative; z-index:2; }
.title span{ color:#1a73e8; }

.container{ display:flex; justify-content:center; margin-top:60px; position:relative; z-index:2; }

.card{
    background:#fff;
    border:1px solid #e0e0e0;
    padding:40px;
    border-radius:20px;
    display:flex;
    flex-direction:column;
    align-items:center;
    gap:15px;
    box-shadow:0 8px 32px rgba(0,0,0,0.08);
}

.card input{
    width:280px; height:70px;
    font-size:20px;
    text-align:center;
    border-radius:12px;
    border:2px solid #e0e0e0;
    background:#dfdfdf;
    color:#1a1a2e;
    outline:none;
    transition:0.3s;
}

.card input:focus{ border-color:#1a73e8; transform:scale(1.05); background:#fff; }

input::placeholder{ font-size:18px; color:#aaa; }

.join-btn{
    background:#1a73e8;
    border:none;
    padding:14px 50px;
    font-size:18px;
    border-radius:14px;
    cursor:pointer;
    font-weight:bold;
    color:#fff;
    box-shadow:0 6px 20px rgba(26,115,232,0.25);
    transition:0.3s;
}

.join-btn:hover{ background:#1558b0; transform:scale(1.05); }

.random-btn{
    background:transparent;
    border:1px solid #e0e0e0;
    color:#555;
    padding:10px 20px;
    border-radius:12px;
    cursor:pointer;
    transition:0.3s;
}

.random-btn:hover{ background:#f0f4ff; color:#1a73e8; border-color:#1a73e8; transform:scale(1.05); }

.alert-success{
    position:fixed; top:20px; right:20px;
    background:#fff;
    border-left:4px solid #1a73e8;
    color:#1a1a2e;
    padding:12px 16px;
    border-radius:10px;
    z-index:99999;
    font-weight:600;
    box-shadow:0 6px 20px rgba(0,0,0,0.1);
}
</style>
</head>

<body>

@include('components.navbar')

@if (session('success'))
<div class="alert-success">{{ session('success') }}</div>
@endif

<div class="title"><span>Join</span> Room</div>

<div class="container">
<form method="POST" action="/rooms/confirm-join"> @csrf
    <div class="card">
        @if(session('error'))
            <div style="background:rgba(231,76,60,0.08);border:1px solid #e74c3c;color:#e74c3c;padding:10px 15px;border-radius:10px;">
                {{ session('error') }}
            </div>
        @endif

        <input type="hidden" name="room_id" value="{{ $room_id }}">
        <input name="user_name" type="text" placeholder="Type your username..." required>

        @error('user_name')
        <div style="color:#e74c3c;font-size:13px;font-weight:bold;">{{ $message }}</div>
        @enderror

        <button type="button" class="random-btn" onclick="generateUsername()">Random Username</button>
        <button class="join-btn" type="submit">Join Room</button>
    </div>
</form>
</div>

<script>
function generateUsername() {
    const adjectives = ["Dark","Fast","Crazy","Silent","Happy","Fire","Blue","Ultra","Ghost","Mega"];
    const nouns = ["Tiger","Wolf","Ninja","Coder","Dragon","Player","King","Shadow","Hunter","Fox"];
    const name = adjectives[Math.floor(Math.random()*adjectives.length)] + nouns[Math.floor(Math.random()*nouns.length)] + Math.floor(Math.random()*9999);
    document.querySelector('input[name="user_name"]').value = name;
}
</script>

</body>
</html>
