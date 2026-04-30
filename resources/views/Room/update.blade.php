<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Room</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: #f0f2f5;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 40px 20px 60px;
            color: #1a1a2e;
        }

        .card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 4px 32px rgba(0,0,0,0.08);
            width: 100%;
            max-width: 560px;
            padding: 40px 40px 36px;
        }

        .card-header {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 32px;
        }
        .card-header .icon-wrap {
            width: 46px; height: 46px;
            background: #e8f0fe;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            color: #1a73e8;
        }
        .card-header h1 { font-size: 20px; font-weight: 700; color: #1a1a2e; }
        .card-header p  { font-size: 13px; color: #888; margin-top: 2px; }

        .field { margin-bottom: 20px; }
        .field label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #444;
            margin-bottom: 7px;
        }
        .field input[type="text"],
        .field input[type="number"],
        .field textarea {
            width: 100%;
            padding: 12px 16px;
            border: 1.5px solid #e0e0e0;
            border-radius: 10px;
            font-size: 14px;
            color: #1a1a2e;
            background: #fafafa;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
        }
        .field input:focus, .field textarea:focus {
            border-color: #1a73e8;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(26,115,232,0.1);
        }
        .field textarea { height: 100px; resize: none; }

        .divider { height: 1px; background: #f0f0f0; margin: 24px 0; }

        .row-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }

        .vis-toggle {
            display: grid;
            grid-template-columns: 1fr 1fr;
            background: #f0f2f5;
            border-radius: 10px;
            padding: 4px;
            gap: 4px;
        }
        .vis-toggle label {
            display: flex; align-items: center; justify-content: center; gap: 7px;
            padding: 10px; border-radius: 8px; cursor: pointer;
            font-size: 13px; font-weight: 600; color: #888;
            transition: all 0.2s; user-select: none;
        }
        .vis-toggle input { display: none; }
        .vis-toggle input:checked + label {
            background: #fff; color: #1a73e8;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        .vis-toggle label .material-icons-round { font-size: 16px; }

        .member-wrap { display: flex; flex-direction: column; gap: 8px; }
        .member-options { display: flex; gap: 8px; }
        .member-options label {
            flex: 1; display: flex; align-items: center; justify-content: center; gap: 6px;
            padding: 10px; border: 1.5px solid #e0e0e0; border-radius: 10px;
            cursor: pointer; font-size: 13px; font-weight: 600; color: #888;
            background: #fafafa; transition: all 0.2s; user-select: none;
        }
        .member-options input { display: none; }
        .member-options input:checked + label {
            border-color: #1a73e8; color: #1a73e8; background: #e8f0fe;
        }
        .member-options label .material-icons-round { font-size: 16px; }

        #limitInput {
            display: none; width: 100%;
            padding: 11px 16px; border: 1.5px solid #e0e0e0;
            border-radius: 10px; font-size: 14px; color: #1a1a2e;
            background: #fafafa; outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        #limitInput:focus { border-color: #1a73e8; background: #fff; box-shadow: 0 0 0 3px rgba(26,115,232,0.1); }
        #limitInput.show { display: block; }

        .submit-btn {
            width: 100%; padding: 14px;
            background: #1a73e8; color: #fff;
            border: none; border-radius: 12px;
            font-size: 15px; font-weight: 700;
            cursor: pointer; margin-top: 28px;
            transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
            box-shadow: 0 4px 16px rgba(26,115,232,0.25);
            display: flex; align-items: center; justify-content: center; gap: 8px;
        }
        .submit-btn:hover { background: #1558b0; transform: translateY(-2px); box-shadow: 0 8px 24px rgba(26,115,232,0.3); }
        .submit-btn:active { transform: translateY(0); }

        .toast {
            position: fixed; top: 24px; right: 24px;
            display: flex; align-items: center; gap: 12px;
            background: #fff; border-left: 4px solid #1a73e8;
            padding: 14px 20px; border-radius: 12px;
            box-shadow: 0 8px 28px rgba(0,0,0,0.12);
            animation: slideIn 0.35s ease; z-index: 9999; font-size: 14px;
        }
        .toast .t-icon {
            width: 28px; height: 28px; background: #1a73e8; color: #fff;
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            font-size: 13px; flex-shrink: 0;
        }
        .toast strong { display: block; font-size: 14px; color: #1a1a2e; }
        .toast span { font-size: 12px; color: #888; }
        @keyframes slideIn { from { opacity:0; transform:translateX(60px); } to { opacity:1; transform:translateX(0); } }
        .fade-out { animation: fadeOut 0.35s forwards; }
        @keyframes fadeOut { to { opacity:0; transform:translateX(60px); } }

        @media (max-width: 480px) {
            .card { padding: 28px 20px; }
            .row-2 { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    @include('components.navbar')

    @if(session('success'))
    <div id="toast" class="toast">
        <div class="t-icon"><span class="material-icons-round" style="font-size:15px">check</span></div>
        <div><strong>Room Updated!</strong><span>{{ session('success') }}</span></div>
    </div>
    @endif

    @isset($data)
    <div class="card">
        <div class="card-header">
            <div class="icon-wrap">
                <span class="material-icons-round" style="font-size:24px">edit</span>
            </div>
            <div>
                <h1>Update Room</h1>
                <p>Edit your room settings</p>
            </div>
        </div>

        <form action="/update/{{ $data->id }}" method="POST">
            @csrf

            <div class="field">
                <label>Room Name</label>
                <input type="text" name="room_name" value="{{ $data->name }}" required>
            </div>

            <div class="field">
                <label>Description <span style="color:#bbb;font-weight:400">(optional)</span></label>
                <textarea name="room_desc">{{ $data->description }}</textarea>
            </div>

            <div class="divider"></div>

            <div class="row-2">
                <div class="field">
                    <label>Visibility</label>
                    <div class="vis-toggle">
                        <input type="radio" name="visibility" id="vis-private" value="private" {{ $data->visibility == 'private' ? 'checked' : '' }}>
                        <label for="vis-private"><span class="material-icons-round">lock</span> Private</label>

                        <input type="radio" name="visibility" id="vis-public" value="public" {{ $data->visibility == 'public' ? 'checked' : '' }}>
                        <label for="vis-public"><span class="material-icons-round">public</span> Public</label>
                    </div>
                </div>

                <div class="field">
                    <label>Members</label>
                    <div class="member-wrap">
                        <div class="member-options">
                            <input type="radio" name="member_type" id="mem-unlimited" value="unlimited" {{ !$data->member_limit ? 'checked' : '' }}>
                            <label for="mem-unlimited"><span class="material-icons-round">all_inclusive</span> Unlimited</label>

                            <input type="radio" name="member_type" id="mem-limited" value="limited" {{ $data->member_limit ? 'checked' : '' }}>
                            <label for="mem-limited"><span class="material-icons-round">group</span> Limited</label>
                        </div>
                        <input type="number" id="limitInput" name="member_limit" value="{{ $data->member_limit }}" placeholder="Max members..." min="1" class="{{ $data->member_limit ? 'show' : '' }}">
                    </div>
                </div>
            </div>

            <button type="submit" class="submit-btn">
                Save Changes
                <span class="material-icons-round" style="font-size:18px">arrow_forward</span>
            </button>
        </form>
    </div>
    @endisset

    <script>
        document.querySelectorAll('input[name="member_type"]').forEach(r => {
            r.addEventListener('change', () => {
                const inp = document.getElementById('limitInput');
                if (r.value === 'limited' && r.checked) {
                    inp.classList.add('show');
                    inp.required = true;
                } else if (r.value === 'unlimited' && r.checked) {
                    inp.classList.remove('show');
                    inp.required = false;
                    inp.value = '';
                }
            });
        });

        const toast = document.getElementById('toast');
        if (toast) {
            setTimeout(() => {
                toast.classList.add('fade-out');
                setTimeout(() => toast.remove(), 350);
            }, 3000);
        }
    </script>
</body>
</html>
