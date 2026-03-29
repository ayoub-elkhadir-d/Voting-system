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
            padding-top: 90px; /* مهم باش navbar */
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

        .nav-links {
            display: flex;
            list-style: none;
            gap: 30px;
        }

        .nav-links a {
            color: #bbb;
            text-decoration: none;
            transition: 0.3s;
        }

        .nav-links a:hover {
            color: #f39c12;
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
            font-size: 1.8rem;
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
            margin-bottom: 20px;
        }

        .room-actions {
            display: flex;
            justify-content: space-between;
        }

        .btn {
            border: none;
            padding: 10px 18px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 0.85rem;
            transition: 0.3s;
        }

        .btn.enter {
            background-color: #f39c12;
            color: #fff;
        }

        .btn.enter:hover {
            background-color: #e67e22;
        }

        .btn.delete {
            background-color: #2c2c2c;
            color: #ccc;
        }

        .btn.delete:hover {
            background-color: #e74c3c;
            color: #fff;
        }
        .alert-success {
    position: fixed;
    top: 20px;
    right: 20px;
    display: flex;
    align-items: center;
    gap: 12px;
    background: #e6f9f0;
    border-left: 5px solid #28a745;
    color: #155724;
    padding: 15px 20px;
    border-radius: 10px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    animation: slideIn 0.5s ease;
    z-index: 9999;
}

.alert-success .icon {
    font-size: 18px;
    background: #28a745;
    color: white;
    border-radius: 50%;
    padding: 6px 9px;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateX(100%);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.fade-out {
    animation: fadeOut 0.5s forwards;
}

@keyframes fadeOut {
    to {
        opacity: 0;
        transform: translateX(100%);
    }
}
    </style>
</head>
<body>

 @include('components.navbar')
  @if (session('success'))
    <div id="successAlert" class="alert-success">
        <span class="icon">✔</span>
        <div>
            <strong>Success</strong>
            <p>{{ session('success') }}</p>
        </div>
    </div>
@endif
    <!-- ROOMS -->
    <div class="rooms-container">
        <h2 class="title">My Rooms</h2>

        <div class="rooms-grid">

            <div class="rooms-grid">
    @foreach($rooms as $room)
        <div class="room-card">
            <h3 class="room-name">{{ $room->name }}</h3>
            <p class="room-desc">{{ $room->description }}</p>

            <div class="room-actions">
                <a href="/room/{{ $room->id }}" class="btn enter">Enter</a>

                <form action="/delete/{{ $room->id }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn delete">Delete</button>
                </form>
            </div>
        </div>
    @endforeach
</div>

          

        </div>
    </div>

</body>
<script>
    
  setTimeout(() => {
    const alert = document.getElementById("successAlert");
    if (alert) {
        alert.classList.add("fade-out");
        setTimeout(() => alert.remove(), 500);
    }
}, 3000);
</script>
</html>