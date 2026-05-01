<style>
    * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', sans-serif; }

    .navbar {
        width: 100%;
        height: 68px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 40px;
        position: fixed;
        top: 0; left: 0;
        z-index: 1000;
        box-shadow: rgba(26, 33, 71, 0.16) 0px 4px 16px 0px;
        border-bottom: 2px solid #1a73e8;
        background: #fff;
    }

    body { padding-top: 88px; background-color: #f0f0f0; color: #1a1a2e; }

    .logo { display: flex; align-items: center; gap: 10px; }
    .logo img { width: 42px; height: 42px; object-fit: contain; border-radius: 8px; border: 2px solid #1a73e8; }
    .logo-text { font-size: 18px; font-weight: 800; color: #1a73e8; letter-spacing: 1px; }

    .nav-links { list-style: none; display: flex; gap: 32px; margin: 0; padding: 0; }
    .nav-links a { text-decoration: none; color: #444; font-size: 15px; font-weight: 600; transition: color 0.2s; position: relative; padding-bottom: 4px; }
    .nav-links a::after { content: ''; position: absolute; bottom: 0; left: 0; width: 0; height: 2px; background: #1a73e8; transition: width 0.25s; }
    .nav-links a:hover { color: #1a73e8; }
    .nav-links a:hover::after { width: 100%; }

    .nav-right { display: flex; align-items: center; gap: 16px; }
    .username { color: #444; font-size: 13px; line-height: 1.5; text-align: right; }
    .username strong { color: #1a73e8; }

    .avatar { width: 38px; height: 38px; border-radius: 50%; overflow: hidden; border: 2px solid #1a73e8; box-shadow: 0 0 8px rgba(26,115,232,0.2); }
    .avatar img { width: 100%; height: 100%; object-fit: cover; }

    .nav-btn { background-color: #1a73e8; color: #fff; border: none; padding: 9px 20px; border-radius: 8px; cursor: pointer; font-weight: 700; font-size: 14px; transition: 0.2s; box-shadow: 0 3px 10px rgba(26,115,232,0.2); }
    .nav-btn:hover { background-color: #1558b0; transform: translateY(-2px); box-shadow: 0 6px 16px rgba(26,115,232,0.3); }
    .nav-btn-outline { background-color: transparent; color: #1a73e8; border: 2px solid #1a73e8; box-shadow: none; }
    .nav-btn-outline:hover { background-color: rgba(26,115,232,0.08); transform: translateY(-2px); }

    /* Hamburger */
    .hamburger { display: none; flex-direction: column; gap: 5px; cursor: pointer; padding: 4px; background: none; border: none; }
    .hamburger span { display: block; width: 24px; height: 2px; background: #1a73e8; border-radius: 2px; transition: 0.3s; }
    .hamburger.open span:nth-child(1) { transform: translateY(7px) rotate(45deg); }
    .hamburger.open span:nth-child(2) { opacity: 0; }
    .hamburger.open span:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }

    /* Mobile menu */
    .mobile-menu {
        display: none;
        position: fixed;
        top: 68px; left: 0;
        width: 100%;
        background: #fff;
        border-bottom: 2px solid #1a73e8;
        box-shadow: 0 8px 24px rgba(0,0,0,0.1);
        z-index: 999;
        padding: 20px;
        flex-direction: column;
        gap: 12px;
    }
    .mobile-menu.open { display: flex; }
    .mobile-menu a { color: #444; text-decoration: none; font-size: 15px; font-weight: 600; padding: 10px 0; border-bottom: 1px solid #f0f0f0; }
    .mobile-menu a:hover { color: #1a73e8; }
    .mobile-menu .mobile-user { font-size: 13px; color: #888; padding: 8px 0; border-bottom: 1px solid #f0f0f0; }
    .mobile-menu .mobile-user strong { color: #1a73e8; display: block; }
    .mobile-menu form button { width: 100%; margin-top: 4px; }

    @media (max-width: 768px) {
        .navbar { padding: 0 20px; }
        .nav-links, .nav-right { display: none; }
        .hamburger { display: flex; }
    }
</style>

<nav class="navbar">
    <div class="logo">
        <img src="https://static.vecteezy.com/system/resources/previews/017/114/596/non_2x/vote-rights-tick-icon-sign-symbol-design-vector.jpg" alt="logo">
        <span class="logo-text">SystemVote</span>
    </div>

    <ul class="nav-links">
        <li><a href="/dashboard">Dashboard</a></li>
        <li><a href="/myrooms">Rooms</a></li>
        <li><a href="#">Statistiques</a></li>
        @auth
            @if(auth()->user()->isSuperAdmin())
            <li><a href="/superadmin" style="color:#e74c3c;font-weight:800;"><i class="fa-solid fa-shield-halved"></i> Admin Panel</a></li>
            @endif
        @endauth
    </ul>

    <div class="nav-right">
        @auth
            <span class="username">
                <strong>{{ auth()->user()->name }}</strong><br>
                <small>{{ auth()->user()->email }}</small>
            </span>
        @endauth
        <div class="avatar">
            <img src="https://images.pexels.com/photos/1222271/pexels-photo-1222271.jpeg" alt="avatar">
        </div>
        <form action="/roomcreate" method="get">
            <button class="nav-btn">+ Create Room</button>
        </form>
        <form action="/logout" method="POST">
            @csrf
            <button class="nav-btn nav-btn-outline">Logout</button>
        </form>
    </div>

    <button class="hamburger" id="hamburger" aria-label="Menu">
        <span></span><span></span><span></span>
    </button>
</nav>

<div class="mobile-menu" id="mobileMenu">
    @auth
        <div class="mobile-user">
            <strong>{{ auth()->user()->name }}</strong>
            {{ auth()->user()->email }}
        </div>
    @endauth
    <a href="/dashboard">Dashboard</a>
    <a href="/myrooms">Rooms</a>
    <a href="#">Statistiques</a>
    @auth
        @if(auth()->user()->isSuperAdmin())
        <a href="/superadmin" style="color:#e74c3c;font-weight:800;">⚙ Admin Panel</a>
        @endif
    @endauth
    <form action="/roomcreate" method="get">
        <button class="nav-btn" style="width:100%;margin-top:8px;">+ Create Room</button>
    </form>
    <form action="/logout" method="POST">
        @csrf
        <button class="nav-btn nav-btn-outline" style="width:100%;margin-top:4px;">Logout</button>
    </form>
</div>

<script>
    const hamburger = document.getElementById('hamburger');
    const mobileMenu = document.getElementById('mobileMenu');
    hamburger.addEventListener('click', () => {
        hamburger.classList.toggle('open');
        mobileMenu.classList.toggle('open');
    });
</script>
