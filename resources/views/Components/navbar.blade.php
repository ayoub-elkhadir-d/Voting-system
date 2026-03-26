
<title>Navbar</title>

<style>


.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #000000;
    padding: 12px 25px;
}
.navbar {
    width: 100%;
    height: 70px;
    background-color: #121212;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 50px;
    position: fixed;  
    top: 0;         
    left: 0;
    z-index: 1000;
    border-bottom: 1px solid #333;
}


body {
    padding-top: 100px;
}
.logo {
    font-size: 22px;
    color: #FCA311;
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
    color: white;
    font-size: 16px;
    transition: 0.3s;
}

.nav-links a:hover {
    color: #FCA311;
}

.nav-right {
    display: flex;
    align-items: center;
    gap: 15px;
}

.username {
    color: white;
    font-size: 14px;
}

.avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background-color: #FCA311;
}

.btn {
    background-color: #FCA311;
    border: none;
    padding: 8px 15px;
    border-radius: 6px;
    cursor: pointer;
    font-weight: bold;
    transition: 0.3s;
}

.btn:hover {
    background-color: #e5940e;
}

/* logout button style */
.logout-btn {
    background-color: red;
    color: white;
}
.avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    overflow: hidden; 
}

.avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover; 
}
.logo {
    display: flex;
    align-items: center;
}

.logo img {
    width: 40px; 
    height: 40px;
    object-fit: contain;
}
</style>

</head>
<body>

<nav class="navbar">
    
<div class="logo">
    <img src="https://static.vecteezy.com/system/resources/previews/017/114/596/non_2x/vote-rights-tick-icon-sign-symbol-design-vector.jpg" alt="logo">
</div>

    <ul class="nav-links">
        <li><a href="#">Dashboard</a></li>
        <li><a href="#">Rooms</a></li>
        <li><a href="#">Statistiques</a></li>
    </ul>

    <div class="nav-right">

        @auth
            <span class="username">
                👤 {{ auth()->user()->name }} <br>
                📧 {{ auth()->user()->email }}
            </span>
        @endauth

       <div class="avatar">
    <img src="https://images.pexels.com/photos/1222271/pexels-photo-1222271.jpeg" alt="avatar">
</div>
       
        <form action="/roomcreate" method="post">
            @csrf
            <button class="btn">Create Room</button>
        </form>

    
        <form action="/logout" method="POST">
            @csrf
            <button class="btn logout-btn">Logout</button>
        </form>

    </div>

</nav>
