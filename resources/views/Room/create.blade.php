<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Room</title>
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
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;

        }

        .container {
            width: 100%;
            max-width: 950px;
        }

        .main-grid {
            display: grid;
            grid-template-columns: 1.2fr 1fr;
            gap: 60px;
        }

        h3 {
            color: #f39c12;
            margin-bottom: 20px;
            font-size: 1.1rem;
            text-transform: capitalize;
        }

        .section {
            margin-bottom: 35px;
        }

        
        .input-field {
            width: 100%;
            background: #252525;
            border: 2px solid transparent;
            border-radius: 10px;
            padding: 18px;
            color: #fff;
            margin-bottom: 15px;
            outline: none;
            transition: 0.3s;
        }

        .input-field:focus {
            border-color: #f39c12;
        }

        .textarea {
            height: 120px;
            resize: none;
        }

        .settings-row {
            display: flex;
            gap: 50px;
        }

        .radio-container {
            display: flex;
            align-items: center;
            position: relative;
            padding-left: 35px;
            margin-bottom: 15px;
            cursor: pointer;
            font-size: 0.95rem;
        }

        .radio-container input {
            position: absolute;
            opacity: 0;
        }

        .checkmark {
            position: absolute;
            left: 0;
            height: 20px;
            width: 20px;
            background-color: #fff;
            border-radius: 50%;
        }

        .radio-container input:checked ~ .checkmark {
            background-color: #3498db;
            border: 4px solid #fff;
        }

        .limit-group {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .small-input {
            background: #252525;
            border: none;
            border-radius: 6px;
            padding: 10px;
            width: 110px;
            color: #888;
            font-size: 0.85rem;
        }

        /* Visibility Toggle */
        .toggle-switch {
            background: #121212;
            padding: 6px;
            border-radius: 30px;
            display: inline-flex;
            gap: 5px;
        }

        .toggle-option {
            padding: 10px 25px;
            border-radius: 25px;
            cursor: pointer;
            font-size: 0.9rem;
            transition: 0.3s;
            user-select: none;
        }

        .toggle-option.active {
            background: #444;
            font-weight: bold;
        }

        .voting-options {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .voting-card {
            background: #1a1a1a;
            padding: 18px;
            border-radius: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            transition: 0.2s;
            border: 1px solid transparent;
        }

        .voting-card:hover {
            background: #222;
        }

        .voting-card.selected {
            border-color: #3498db;
        }

        .card-content {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .icon {
            color: #f39c12;
            font-size: 1.2rem;
        }

        .card-text .title {
            font-size: 0.95rem;
            font-weight: 600;
        }

        .card-text .desc {
            font-size: 0.8rem;
            color: #777;
            margin-top: 2px;
        }

        /* Create Button */
        .footer {
            display: flex;
            justify-content: center;
            margin-top: 50px;
        }

        .create-btn {
            background-color: #f39c12;
            color: #fff;
            border: none;
            padding: 18px 80px;
            font-size: 1.6rem;
            font-weight: 800;
            border-radius: 12px;
            cursor: pointer;
            transition: transform 0.2s, background 0.3s;
            box-shadow: 0 4px 15px rgba(243, 156, 18, 0.3);
        }

        .create-btn:hover {
            background-color: #e67e22;
            transform: translateY(-3px);
        }

        .create-btn:active {
            transform: translateY(0);
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
    <span>
         @include('components.navbar')
    </span>
       


    <div class="container">
  @if (session('success'))
    <div id="successAlert" class="alert-success">
        <span class="icon">✔</span>
        <div>
            <strong>Success</strong>
            <p>{{ session('success') }}</p>
        </div>
    </div>
@endif
        <form action="/createroom" method="POST" id="roomForm">
            @csrf
            <div class="main-grid">
                    <div class="left-col">
                    <div class="section">
                        <h3>Room info</h3>
                        <input type="text" name="room_name" placeholder="Enter Name Room .." class="input-field" required>
                        <textarea name="room_desc" placeholder="Description ..." class="input-field textarea"></textarea>
                    </div>

                    <div class="settings-row">
                        <div class="section">
                            <h3>Member settings</h3>
                            <label class="radio-container">
                                <input type="radio" name="member_type" value="unlimited" checked>
                                <span class="checkmark"></span> Unlimited
                            </label>
                            <div class="limit-group">
                                <label class="radio-container">
                                    <input type="radio" name="member_type" value="limited">
                                    <span class="checkmark"></span> Limited
                                </label>
                                <input type="number" name="member_limit" placeholder="Entre limit .." class="small-input">
                            </div>
                        </div>

                        <div class="section">
                            <h3>Visibility settings</h3>
                            <div class="toggle-switch">
                                <div class="toggle-option active" data-value="private">Private</div>
                                <div class="toggle-option" data-value="public">Public</div>
                            </div>
                            <input type="hidden" name="visibility" id="visibilityInput" value="private">
                        </div>
                    </div>
                </div>

                <div class="right-col">
                    <div class="section">
                        <h3>Select Voting Method</h3>
                        <div class="voting-options">
                            
                            <label class="voting-card">
                                <div class="card-content">
                                    <span class="icon">%</span>
                                    <div class="card-text">
                                        <p class="title">Percentage (%)</p>
                                        <p class="desc">Vote based on percentage values.</p>
                                    </div>
                                </div>
                                <input type="radio" name="vote_method" value="percentage" checked>
                                <span class="checkmark"></span>
                            </label>

                            <label class="voting-card">
                                <div class="card-content">
                                    <span class="icon">★</span>
                                    <div class="card-text">
                                        <p class="title">Scale 1-10</p>
                                        <p class="desc">Rate from 1 to 10.</p>
                                    </div>
                                </div>
                                <input type="radio" name="vote_method" value="scale">
                                <span class="checkmark"></span>
                            </label>

                            <label class="voting-card">
                                <div class="card-content">
                                    <span class="icon">Y</span>
                                    <div class="card-text">
                                        <p class="title">Fibonacci (1,2,3,5,8,13)</p>
                                        <p class="desc">Use Fibonacci sequence for voting.</p>
                                    </div>
                                </div>
                                <input type="radio" name="vote_method" value="fibonacci">
                                <span class="checkmark"></span>
                            </label>

                            <label class="voting-card">
                                <div class="card-content">
                                    <span class="icon">⚙</span>
                                    <div class="card-text">
                                        <p class="title">Custom Values</p>
                                        <p class="desc">Define your own voting values.</p>
                                    </div>
                                </div>
                                <input type="radio" name="vote_method" value="custom">
                                <span class="checkmark"></span>
                            </label>

                        </div>
                    </div>
                </div>
            </div>

            <div class="footer">
                <button type="submit" class="create-btn">Create Room</button>
            </div>
        </form>
    </div>

    <script>
     
        const toggleOptions = document.querySelectorAll('.toggle-option');
        const visibilityInput = document.getElementById('visibilityInput');

        toggleOptions.forEach(option => {
            option.addEventListener('click', () => {
             
                toggleOptions.forEach(opt => opt.classList.remove('active'));
               
                option.classList.add('active');
               
                visibilityInput.value = option.getAttribute('data-value');
            });
        });

        document.getElementById('roomForm').addEventListener('submit', (e) => {
            const formData = new FormData(e.target);
            console.log("Data to be sent:");
            for (let [key, value] of formData.entries()) {
                console.log(`${key}: ${value}`);
            }
        });
       setTimeout(() => {
    const alert = document.getElementById("successAlert");
    if (alert) {
        alert.classList.add("fade-out");
        setTimeout(() => alert.remove(), 500);
    }
}, 3000);
    </script>
</body>
</html>