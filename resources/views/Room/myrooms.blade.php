<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Rooms</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI',sans-serif;
}

body{
    background:radial-gradient(circle at top,#1a1a1a,#0b0b0f);
    color:#fff;
    padding-top:90px;
}

.navbar{
    position:fixed;
    top:0;
    width:100%;
    z-index:10000;
}

.rooms-container{
    max-width:1200px;
    margin:auto;
    padding:20px;
}

.title{
    font-size:26px;
    font-weight:bold;
    margin-bottom:25px;
    background:linear-gradient(135deg,#ffb703,#ff6a00);
    -webkit-background-clip:text;
    -webkit-text-fill-color:transparent;
}

.rooms-grid{
    display:grid;
    grid-template-columns:repeat(auto-fill,minmax(280px,1fr));
    gap:25px;
}

.room-card{
    background:rgba(255,255,255,0.05);
    backdrop-filter:blur(12px);
    border:1px solid rgba(255,255,255,0.08);
    border-radius:18px;
    padding:20px;
    position:relative;
    cursor:pointer;
    transition:0.3s;
    overflow:visible;
}

.room-card.active-menu {
    z-index: 1001;
}

.room-card:hover{
    transform:translateY(-6px) scale(1.02);
    border-color:#ffb703;
}

.room-name{
    font-size:18px;
    font-weight:bold;
    margin-bottom:8px;
}

.room-desc{
    color:#aaa;
    font-size:14px;
}

.menu{
    position:absolute;
    top:12px;
    right:12px;
    z-index:1000;
}

.menu-btn{
    font-size:20px;
    cursor:pointer;
    color:#bbb;
    padding:6px 8px;
    border-radius:8px;
    transition:0.2s;
}

.menu-btn:hover{
    background:rgba(255,255,255,0.1);
    color:#ffb703;
}

.menu-content{
    position:absolute;
    top:35px;
    right:0;
    background:rgba(0,0,0,0.95);
    border:1px solid rgba(255,255,255,0.1);
    border-radius:12px;
    min-width:160px;
    display:none;
    backdrop-filter:blur(10px);
    z-index:9999;
    animation:fadeIn 0.2s ease;
}

@keyframes fadeIn{
    from{opacity:0; transform:translateY(-5px);}
    to{opacity:1; transform:translateY(0);}
}

.menu-content a,
.menu-content button{
    display:flex;
    align-items:center;
    gap:10px;
    width:100%;
    padding:10px 12px;
    background:none;
    border:none;
    color:#ccc;
    cursor:pointer;
    font-size:14px;
    transition:0.2s;
}

.menu-content a:hover,
.menu-content button:hover{
    background:rgba(255,255,255,0.08);
    color:#ffb703;
}

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

@media(max-width:600px){
    .title{font-size:20px;}
}
</style>
</head>

<body>

@include('components.navbar')

@if (session('success'))
<div class="alert-success">{{ session('success') }}</div>
@endif

<div class="rooms-container">
    <h2 class="title">My Rooms</h2>

    <div class="rooms-grid">
        @foreach($rooms as $room)
        <div class="room-card" onclick="goToRoom(event, {{$room->id}})">
            <div class="menu">
                <div class="menu-btn" onclick="toggleMenu(event,this)">⋮</div>
                <div class="menu-content">
                    <a href="/show/{{$room->id}}">▶ Start</a>
                    <a href="/update/{{$room->id}}">✏ Edit</a>
                    <form action="/delete/{{$room->id}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit">🗑 Delete</button>
                    </form>
                </div>
            </div>
            <h3 class="room-name">{{ $room->name }}</h3>
            <p class="room-desc">{{ $room->description }}</p>
        </div>
        @endforeach
    </div>
</div>

<script>
function goToRoom(e, id){
    if(e.target.closest('.menu')) return;
    window.location.href = "/show/" + id;
}

function toggleMenu(e,btn){
    e.stopPropagation();
    const menu = btn.nextElementSibling;
    const card = btn.closest('.room-card');

    document.querySelectorAll('.menu-content').forEach(m=>{
        if(m!==menu) {
            m.style.display='none';
            m.closest('.room-card').classList.remove('active-menu');
        }
    });

    if(menu.style.display === 'block'){
        menu.style.display = 'none';
        card.classList.remove('active-menu');
    } else {
        menu.style.display = 'block';
        card.classList.add('active-menu');
    }
}

window.addEventListener('click',()=>{
    document.querySelectorAll('.menu-content').forEach(m=>{
        m.style.display='none';
        const card = m.closest('.room-card');
        if(card) card.classList.remove('active-menu');
    });
});
</script>

</body>
</html>