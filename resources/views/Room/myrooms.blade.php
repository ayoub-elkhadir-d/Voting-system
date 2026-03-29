<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Rooms</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Roboto, sans-serif;
        }

        body {
            background-color: #1a1a1a;
            color: #fff;
            padding-top: 90px;
        }

        /* ===== NAVBAR ===== */
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

        .nav-logo {
            color: #f39c12;
            font-size: 1.5rem;
            font-weight: bold;
            text-decoration: none;
        }

        /* ===== ROOMS ===== */
        .rooms-container {
            width: 100%;
            max-width: 1100px;
            margin: auto;
            padding: 20px;
        }

        .title {
            color: #f39c12;
            margin-bottom: 30px;
        }

        .rooms-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 25px;
        }

        .room-card {
            background: #1a1a1a;
            border-radius: 15px;
            padding: 20px;
            border: 1px solid #2c2c2c;
            position: relative;
            transition: 0.3s;
        }

        .room-card:hover {
            transform: translateY(-5px);
            border-color: #f39c12;
        }

        .room-name {
            font-size: 1.2rem;
            margin-bottom: 10px;
        }

        .room-desc {
            color: #aaa;
            font-size: 0.9rem;
        }

        /* ===== MENU ===== */
        .menu {
            position: absolute;
            top: 15px;
            right: 15px;
        }

        .menu-btn {
            cursor: pointer;
            font-size: 20px;
            color: #aaa;
        }

        .menu-btn:hover {
            color: #f39c12;
        }

        .menu-content {
            display: none;
            position: absolute;
            right: 0;
            top: 25px;
            background: #121212;
            border: 1px solid #333;
            border-radius: 10px;
            overflow: hidden;
            min-width: 130px;
        }

        .menu-content a,
        .menu-content button {
            display: block;
            width: 100%;
            padding: 10px;
            text-align: left;
            background: none;
            border: none;
            color: #ccc;
            cursor: pointer;
        }

        .menu-content a:hover,
        .menu-content button:hover {
            background: #1f1f1f;
            color: #f39c12;
        }

        /* ALERT */
        .alert-success {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #e6f9f0;
            color: #155724;
            padding: 15px;
            border-radius: 10px;
        }
    </style>
</head>
<body>

    <!-- NAVBAR -->
    @include('components.navbar')

    <!-- ALERT -->
    @if (session('success'))
        <div id="successAlert" class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- ROOMS -->
    <div class="rooms-container">
        <h2 class="title">My Rooms</h2>

        <div class="rooms-grid">

            @foreach($rooms as $room)
                <div class="room-card">

                    <!-- MENU -->
                    <div class="menu">
                        <div class="menu-btn" onclick="toggleMenu(this)">⋮</div>

                        <div class="menu-content">
                            <a href="/room/{{ $room->id }}">Start</a>
                            <a href="/update/{{ $room->id }}">Edit</a>

                            <form action="/delete/{{ $room->id }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Delete</button>
                            </form>
                        </div>
                    </div>

                    <h3 class="room-name">{{ $room->name }}</h3>
                    <p class="room-desc">{{ $room->description }}</p>

                </div>
            @endforeach

        </div>
    </div>

    <!-- JS -->
    <script>
        function toggleMenu(btn) {
            const menu = btn.nextElementSibling;

            document.querySelectorAll('.menu-content').forEach(m => {
                if (m !== menu) m.style.display = 'none';
            });

            menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
        }

        window.addEventListener('click', function(e) {
            if (!e.target.closest('.menu')) {
                document.querySelectorAll('.menu-content').forEach(m => {
                    m.style.display = 'none';
                });
            }
        });

        // alert hide
        setTimeout(() => {
            const alert = document.getElementById("successAlert");
            if (alert) alert.style.display = "none";
        }, 3000);
    </script>

</body>
</html>