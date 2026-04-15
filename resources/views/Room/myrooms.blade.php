<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Rooms</title>

<style>
*{ margin:0; padding:0; box-sizing:border-box; font-family:'Segoe UI',sans-serif; }

body{ background:#f5f7fb; color:#1a1a2e; padding-top:90px; }

.navbar{ position:fixed; top:0; width:100%; z-index:10000; }

.rooms-container{ max-width:1200px; margin:auto; padding:30px 20px; }

.title{ font-size:26px; font-weight:800; color:#1a73e8; margin-bottom:20px; }

/* search */
.search-box{ margin-bottom:25px; }

.search-box input{
    width:100%;
    padding:14px 18px;
    border-radius:14px;
    border:1px solid #e0e6f0;
    font-size:14px;
    outline:none;
}

.search-box input:focus{
    border-color:#1a73e8;
    box-shadow:0 0 0 3px rgba(26,115,232,0.1);
}

/* grid */
.rooms-grid{
    display:grid;
    grid-template-columns:repeat(auto-fill,minmax(290px,1fr));
    gap:24px;
}

/* card */
.room-card{
    background:#fff;
    border-radius:18px;
    overflow:hidden;
    cursor:pointer;
    transition:0.25s;
    box-shadow:0 6px 18px rgba(0,0,0,0.05);
    border:1px solid #e6eaf2;
}

.room-card:hover{
    transform:translateY(-6px);
    box-shadow:0 12px 30px rgba(0,0,0,0.08);
}

/* 🔥 BIG HEADER (new) */
.room-header{
    height:110px;
    display:flex;
    align-items:center;
    justify-content:center;
    color:#fff;
    font-size:52px;
    font-weight:900;
    letter-spacing:2px;
}

/* content */
.room-body{
    padding:18px;
    position:relative;
}

.room-name{
    font-size:17px;
    font-weight:700;
    margin-bottom:6px;
}

.room-desc{
    color:#777;
    font-size:13px;
    line-height:1.5;
}

/* menu */
.menu{ position:absolute; top:12px; right:12px; }

.menu-btn{
    font-size:20px;
    cursor:pointer;
    color:#999;
}

.menu-content{
    position:absolute;
    top:30px;
    right:0;
    background:#fff;
    border-radius:12px;
    min-width:150px;
    display:none;
    box-shadow:0 10px 28px rgba(0,0,0,0.12);
    overflow:hidden;
    z-index:999;
}

.menu-content a,
.menu-content button{
    display:block;
    width:100%;
    padding:10px 12px;
    border:none;
    background:none;
    text-align:left;
    cursor:pointer;
    font-size:14px;
    text-decoration:none;
    color:#1a1a2e;
}

.menu-content a:hover,
.menu-content button:hover{
    background:#f0f4ff;
    color:#1a73e8;
}

/* alert */
.alert-success{
    position:fixed;
    top:20px;
    right:20px;
    background:#fff;
    border-left:4px solid #1a73e8;
    padding:14px 20px;
    border-radius:10px;
    font-weight:600;
    box-shadow:0 6px 20px rgba(0,0,0,0.1);
}
</style>
</head>

<body>

@include('components.navbar')

@if (session('success'))
<div class="alert-success">✔ {{ session('success') }}</div>
@endif

<div class="rooms-container">
    <h2 class="title">My Rooms</h2>

    <div class="search-box">
        <input type="text" id="searchInput" placeholder="Search rooms..." />
    </div>

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

            <!-- BIG HEADER -->
            <div class="room-header" data-name="{{ $room->name }}"></div>

            <!-- BODY -->
            <div class="room-body">
                <h3 class="room-name">{{ $room->name }}</h3>
                <p class="room-desc">{{ $room->description }}</p>
            </div>

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

    document.querySelectorAll('.menu-content').forEach(m=>{
        if(m!==menu) m.style.display='none';
    });

    menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
}

window.addEventListener('click',()=>{
    document.querySelectorAll('.menu-content').forEach(m=> m.style.display='none');
});

function getColor(name){
    let colors = ["#4F46E5","#0EA5E9","#10B981","#F59E0B","#EF4444","#8B5CF6"];
    let hash = 0;
    for(let i=0;i<name.length;i++){
        hash = name.charCodeAt(i) + ((hash << 5) - hash);
    }
    return colors[Math.abs(hash) % colors.length];
}

document.querySelectorAll('.room-header').forEach(el=>{
    let name = el.dataset.name || "";
    let first = name.charAt(0).toUpperCase();

    el.textContent = first;
    el.style.background = getColor(name);
});

const searchInput = document.getElementById('searchInput');

searchInput.addEventListener('input', function () {
    const value = this.value.toLowerCase();

    document.querySelectorAll('.room-card').forEach(card => {
        const name = card.querySelector('.room-name').textContent.toLowerCase();
        const desc = card.querySelector('.room-desc').textContent.toLowerCase();

        card.style.display = (name.includes(value) || desc.includes(value)) ? 'block' : 'none';
    });
});
</script>

</body>
</html>