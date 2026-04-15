<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Room</title>
    <style>
        *{ margin:0; padding:0; box-sizing:border-box; font-family:'Segoe UI',Roboto,sans-serif; }
        body{ background:#dfdfdf; color:#1a1a2e; display:flex; justify-content:center; align-items:flex-start; min-height:100vh; padding:30px 20px; }
        .container{ width:100%; max-width:960px; }
        .page-title{ font-size:22px; font-weight:800; color:#1a73e8; margin-bottom:28px; }
        .main-grid{ display:grid; grid-template-columns:1.2fr 1fr; gap:40px; }
        h3{ color:#1a73e8; margin-bottom:16px; font-size:1rem; text-transform:uppercase; letter-spacing:0.8px; }
        .section{ margin-bottom:30px; }
        .input-field{ width:100%; background:#fff; border:2px solid #e0e0e0; border-radius:10px; padding:14px 16px; color:#1a1a2e; margin-bottom:14px; outline:none; font-size:14px; transition:0.2s; }
        .input-field:focus{ border-color:#1a73e8; box-shadow:0 0 0 3px rgba(26,115,232,0.12); }
        .textarea{ height:110px; resize:none; }
        .settings-row{ display:flex; gap:40px; flex-wrap:wrap; }
        .radio-container{ display:flex; align-items:center; position:relative; padding-left:32px; margin-bottom:14px; cursor:pointer; font-size:14px; color:#1a1a2e; }
        .radio-container input{ position:absolute; opacity:0; }
        .checkmark{ position:absolute; left:0; height:18px; width:18px; background:#fff; border:2px solid #1a73e8; border-radius:50%; transition:0.2s; }
        .radio-container input:checked ~ .checkmark{ background:#1a73e8; border-color:#1a73e8; }
        .limit-group{ display:flex; align-items:center; gap:12px; }
        .small-input{ background:#fff; border:2px solid #e0e0e0; border-radius:8px; padding:10px 12px; width:110px; color:#1a1a2e; font-size:13px; outline:none; }
        .small-input:focus{ border-color:#1a73e8; }
        .toggle-switch{ background:#f0f4ff; padding:5px; border-radius:30px; display:inline-flex; gap:4px; border:1px solid rgba(26,115,232,0.2); }
        .toggle-option{ padding:9px 22px; border-radius:25px; cursor:pointer; font-size:13px; font-weight:600; transition:0.2s; user-select:none; color:#888; }
        .toggle-option.active{ background:#1a73e8; color:#fff; font-weight:700; }
        .voting-options{ display:flex; flex-direction:column; gap:12px; }
        .voting-card{ background:#fff; padding:16px; border-radius:12px; display:flex; justify-content:space-between; align-items:center; cursor:pointer; transition:0.2s; border:2px solid #e0e0e0; box-shadow:0 2px 8px rgba(0,0,0,0.04); }
        .voting-card:hover{ border-color:rgba(26,115,232,0.4); background:#f0f4ff; }
        .voting-card:has(input:checked){ border-color:#1a73e8; }
        .card-content{ display:flex; align-items:center; gap:14px; }
        .icon{ color:#1a73e8; font-size:1.3rem; width:28px; text-align:center; }
        .card-text .title{ font-size:14px; font-weight:700; color:#1a1a2e; }
        .card-text .desc{ font-size:12px; color:#888; margin-top:3px; }
        .footer{ display:flex; justify-content:center; margin-top:40px; }
        .create-btn{ background:#1a73e8; color:#fff; border:none; padding:16px 70px; font-size:1.1rem; font-weight:800; border-radius:12px; cursor:pointer; transition:0.2s; box-shadow:0 5px 18px rgba(26,115,232,0.25); }
        .create-btn:hover{ background:#1558b0; transform:translateY(-3px); box-shadow:0 8px 24px rgba(26,115,232,0.35); }
        .create-btn:active{ transform:translateY(0); }
        .alert-success{ position:fixed; top:20px; right:20px; display:flex; align-items:center; gap:12px; background:#fff; border-left:4px solid #1a73e8; color:#1a1a2e; padding:14px 20px; border-radius:10px; box-shadow:0 8px 24px rgba(0,0,0,0.1); animation:slideIn 0.4s ease; z-index:9999; }
        .alert-success .icon{ font-size:18px; background:#1a73e8; color:#fff; border-radius:50%; padding:5px 8px; font-weight:800; }
        @keyframes slideIn{ from{opacity:0;transform:translateX(100%);} to{opacity:1;transform:translateX(0);} }
        .fade-out{ animation:fadeOut 0.4s forwards; }
        @keyframes fadeOut{ to{opacity:0;transform:translateX(100%);} }
    </style>
</head>
<body>
    <span>@include('components.navbar')</span>

    <div class="container">
        @if (session('success'))
        <div id="successAlert" class="alert-success">
            <span class="icon">✔</span>
            <div><strong>Success</strong><p>{{ session('success') }}</p></div>
        </div>
        @endif

        @isset($data)
        <p class="page-title">Update Room</p>
        <form action="/update/{{ $data->id }}" method="POST">
            @csrf
            <div class="main-grid">
                <div class="left-col">
                    <div class="section">
                        <h3>Room info</h3>
                        <input type="text" name="room_name" placeholder="Room name..." class="input-field" value="{{ $data->name }}" required>
                        <textarea name="room_desc" placeholder="Description..." class="input-field textarea">{{ $data->description }}</textarea>
                    </div>

                    <div class="settings-row">
                        <div class="section">
                            <h3>Members</h3>
                            <label class="radio-container">
                                <input type="radio" name="member_type" value="unlimited" {{ $data->member_limit == null || $data->member_limit == 0 ? 'checked' : '' }}>
                                <span class="checkmark"></span> Unlimited
                            </label>
                            <div class="limit-group">
                                <label class="radio-container">
                                    <input type="radio" name="member_type" value="limited" {{ $data->member_limit > 0 ? 'checked' : '' }}>
                                    <span class="checkmark"></span> Limited
                                </label>
                                <input type="number" name="member_limit" value="{{ $data->member_limit }}" class="small-input">
                            </div>
                        </div>

                        <div class="section">
                            <h3>Visibility</h3>
                            <div class="toggle-switch">
                                <div class="toggle-option {{ $data->visibility == 'private' ? 'active' : '' }}" data-value="private">Private</div>
                                <div class="toggle-option {{ $data->visibility == 'public' ? 'active' : '' }}" data-value="public">Public</div>
                            </div>
                            <input type="hidden" name="visibility" id="visibilityInput" value="{{ $data->visibility }}">
                        </div>
                    </div>
                </div>

                <div class="right-col">
                    <div class="section">
                        <h3>Voting Method</h3>
                        <div class="voting-options">
                            <label class="voting-card">
                                <div class="card-content"><span class="icon">%</span><div class="card-text"><p class="title">Percentage</p><p class="desc">Vote based on percentage values.</p></div></div>
                                <input type="radio" name="vote_method" value="percentage" {{ $data->vote_method == 'percentage' ? 'checked' : '' }}>
                                <span class="checkmark"></span>
                            </label>
                            <label class="voting-card">
                                <div class="card-content"><span class="icon">★</span><div class="card-text"><p class="title">Scale 1-10</p><p class="desc">Rate from 1 to 10.</p></div></div>
                                <input type="radio" name="vote_method" value="scale" {{ $data->vote_method == 'scale' ? 'checked' : '' }}>
                                <span class="checkmark"></span>
                            </label>
                            <label class="voting-card">
                                <div class="card-content"><span class="icon">Y</span><div class="card-text"><p class="title">Fibonacci</p><p class="desc">1, 2, 3, 5, 8, 13...</p></div></div>
                                <input type="radio" name="vote_method" value="fibonacci" {{ $data->vote_method == 'fibonacci' ? 'checked' : '' }}>
                                <span class="checkmark"></span>
                            </label>
                            <label class="voting-card">
                                <div class="card-content"><span class="icon">⚙</span><div class="card-text"><p class="title">Custom Values</p><p class="desc">Define your own values.</p></div></div>
                                <input type="radio" name="vote_method" value="custom" {{ $data->vote_method == 'custom' ? 'checked' : '' }}>
                                <span class="checkmark"></span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer">
                <button type="submit" class="create-btn">Update Room</button>
            </div>
        </form>
        @endisset
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
        setTimeout(() => {
            const alert = document.getElementById("successAlert");
            if (alert) { alert.classList.add("fade-out"); setTimeout(() => alert.remove(), 400); }
        }, 3000);
        document.addEventListener("DOMContentLoaded", () => {
            const active = document.querySelector('.toggle-option.active');
            if (active) document.getElementById('visibilityInput').value = active.dataset.value;
        });
    </script>
</body>
</html>
