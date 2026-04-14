<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Waiting Room | Laravel</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --bg-dark: #1e1e1e;
            --navbar-black: #000000;
            --accent-orange: #f39c12;
            --text-white: #ffffff;
            --card-bg: #121212;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: var(--bg-dark);
            color: var(--text-white);
            height: 100vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .main-container {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        /* Participant Stats */
        .participant-stats {
            position: absolute;
            top: 50px;
            right: 60px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 2rem;
            font-weight: 700;
        }

        .participant-stats svg {
            width: 35px;
            height: 35px;
            fill: white;
        }

        /* Room Display Card */
        .room-display {
            background-color: var(--card-bg);
            padding: 25px 80px;
            border-radius: 10px;
            margin-bottom: 60px;
            text-align: center;
        }

        .room-display h1 {
            color: var(--accent-orange);
            font-size: 2rem;
            font-weight: 700;
            letter-spacing: 1px;
        }

        /* --- New Loading & Text Layout --- */
        .loading-wrapper {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 70px;
        }

        .waiting-text {
            font-size: 2.2rem;
            font-weight: 800;
        }

        .loading-spinner {
            display: flex;
            align-items: center;
        }

        .loading-spinner-inner {
            display: flex;
            gap: 6px;
        }

        .loading-spinner-circle {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: var(--accent-orange);
            animation: loading-spinner 1s ease-in-out infinite;
        }

        /* Staggered animation for circles */
        .loading-spinner-circle:nth-child(2) { animation-delay: 0.2s; }
        .loading-spinner-circle:nth-child(3) { animation-delay: 0.4s; }
        .loading-spinner-circle:nth-child(4) { animation-delay: 0.6s; }
        .loading-spinner-circle:nth-child(5) { animation-delay: 0.8s; }

        @keyframes loading-spinner {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.5); opacity: 0.4; }
        }

        /* Button Style */
        .btn-leave {
            background-color: var(--accent-orange);
            color: #fff;
            border: none;
            padding: 15px 45px;
            border-radius: 10px;
            font-size: 1.4rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .btn-leave:hover {
            transform: translateY(-3px);
            filter: brightness(1.1);
        }

        .btn-leave:active {
            transform: translateY(1px);
        }
    </style>
</head>
<body>

    @include('components.navbar')

    <main class="main-container">
        <div class="participant-stats">
            <svg viewBox="0 0 24 24">
                <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5s-3 1.34-3 3 1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
            </svg>
            <span>12/25</span>
        </div>

        <div class="room-display">
            <h1>User-4585452</h1>
        </div>

        <div class="loading-wrapper">
            <h2 class="waiting-text">Waiting For Participants</h2>
            <div class="loading-spinner">
                <div class="loading-spinner-inner">
                    <div class="loading-spinner-circle"></div>
                    <div class="loading-spinner-circle"></div>
                    <div class="loading-spinner-circle"></div>
                    <div class="loading-spinner-circle"></div>
                    <div class="loading-spinner-circle"></div>
                </div>
            </div>
        </div>

        <form action="#" method="POST">
            @csrf
            <button type="submit" class="btn-leave">Leave Room</button>
        </form>
    </main>

</body>
</html>