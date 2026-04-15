<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login — SystemVote</title>
    <style>
        *{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI',sans-serif;}
        body{background:#f5f7fa;min-height:100vh;display:flex;justify-content:center;align-items:center;}
        .card{background:#fff;padding:44px 40px;border-radius:16px;width:380px;box-shadow:0 8px 32px rgba(0,0,0,0.1);border-top:4px solid #1a73e8;}
        h2{color:#1a1a2e;text-align:center;margin-bottom:28px;font-size:1.6rem;font-weight:800;}
        h2 span{color:#1a73e8;}
        .input-group{margin-bottom:18px;}
        .input-group label{color:#555;font-size:13px;font-weight:600;display:block;margin-bottom:6px;}
        .input-group input{width:100%;padding:13px 14px;border:2px solid #e0e0e0;border-radius:10px;background:#fff;color:#1a1a2e;outline:none;font-size:14px;transition:0.2s;}
        .input-group input:focus{border-color:#1a73e8;box-shadow:0 0 0 3px rgba(26,115,232,0.12);}
        .error-input{border-color:#e74c3c !important;}
        .error-text{color:#e74c3c;font-size:12px;margin-top:4px;display:block;}
        .btn{width:100%;padding:13px;background:#1a73e8;border:none;border-radius:10px;color:#fff;font-weight:800;font-size:15px;cursor:pointer;transition:0.2s;box-shadow:0 4px 14px rgba(26,115,232,0.25);margin-top:6px;}
        .btn:hover{background:#1558b0;transform:translateY(-2px);box-shadow:0 8px 20px rgba(26,115,232,0.35);}
        .footer{text-align:center;margin-top:18px;font-size:13px;color:#888;}
        .footer a{color:#1a73e8;text-decoration:none;font-weight:600;}
        .footer a:hover{text-decoration:underline;}
        .error-box{background:rgba(231,76,60,0.08);border:1px solid #e74c3c;color:#e74c3c;padding:12px;margin-bottom:18px;border-radius:10px;font-size:13px;}
        .error-box ul{padding-left:16px;}
    </style>
</head>
<body>
    <div class="card">
        <h2>Sign <span>In</span></h2>
        @if ($errors->any())
        <div class="error-box"><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
        @endif
        <form method="POST" action="/login">
            @csrf
            <div class="input-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="@error('email') error-input @enderror" placeholder="you@example.com">
                @error('email')<span class="error-text">{{ $message }}</span>@enderror
            </div>
            <div class="input-group">
                <label>Password</label>
                <input type="password" name="password" class="@error('password') error-input @enderror" placeholder="••••••••">
                @error('password')<span class="error-text">{{ $message }}</span>@enderror
            </div>
            <button type="submit" class="btn">Login</button>
        </form>
        <div class="footer">
            <a href="/resetpassword">Forgot password?</a> &nbsp;·&nbsp;
            <a href="/register">Create account</a>
        </div>
    </div>
</body>
</html>
