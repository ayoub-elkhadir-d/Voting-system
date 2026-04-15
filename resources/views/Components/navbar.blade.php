<style>
    .navbar {
        width: 100%;
        height: 70px;
        background-color: #1d2228;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 50px;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1000;
        border-bottom: 2px solid #30475E;
    }

    body {
        padding-top: 100px;
        background-color: #222831;
    }

    .logo {
        display: flex;
        align-items: center;
    }

    .logo img {
        width: 45px;
        height: 45px;
        object-fit: contain;
        border-radius: 8px;
    }

    .nav-links {
        list-style: none;
        display: flex;
        gap: 30px;
        margin: 0;
        padding: 0;
    }

    .nav-links a {
        text-decoration: none;
        color: #DDDDDD;
        font-size: 16px;
        font-weight: 600;
        transition: 0.3s;
    }

    .nav-links a:hover {
        color: #F05454;
    }

    .nav-right {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .username {
        color: #DDDDDD;
        font-size: 13px;
        line-height: 1.4;
        text-align: right;
    }

    .avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        overflow: hidden;
        border: 2px solid #F05454;
    }

    .avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .btn {
        background-color: #F05454;
        color: white;
        border: none;
        padding: 10px 18px;
        border-radius: 6px;
        cursor: pointer;
        font-weight: bold;
        transition: 0.3s;
    }

    .btn:hover {
        background-color: #d44646;
        transform: translateY(-2px);
    }

    .logout-btn {
        background-color: transparent;
        color: #F05454;
        border: 1px solid #F05454;
    }

    .logout-btn:hover {
        background-color: rgba(240, 84, 84, 0.1);
    }
</style>

<nav class="navbar">
    <div class="logo">
        <img src="https://static.vecteezy.com/system/resources/previews/017/114/596/non_2x/vote-rights-tick-icon-sign-symbol-design-vector.jpg" alt="logo">
    </div>

    <ul class="nav-links">
        <li><a href="#">Dashboard</a></li>
        <li><a href="/myrooms">Rooms</a></li>
        <li><a href="#">Statistiques</a></li>
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
            <button class="btn">Create Room</button>
        </form>

        <form action="/logout" method="POST">
            @csrf
            <button class="btn logout-btn">Logout</button>
        </form>
    </div>
</nav>