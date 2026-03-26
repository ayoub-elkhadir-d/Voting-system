<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <title>Reset Password</title>
      <style>
         *{margin:0;padding:0;box-sizing:border-box;font-family:Arial;}
         body{background:#262728;height:100vh;display:flex;justify-content:center;align-items:center;}
         .container{background:#2f3031;padding:40px;border-radius:12px;width:360px;box-shadow:0 10px 25px rgba(0,0,0,0.5);}
         h2{color:#fff;text-align:center;margin-bottom:20px;}
         .input-group{margin-bottom:18px;}
         .input-group label{color:#ccc;font-size:14px;display:block;margin-bottom:5px;}
         .input-group input{width:100%;padding:12px;border:none;border-radius:8px;background:#1B1B1B;color:#fff;outline:none;}
         .input-group input:focus{border:1px solid #FCA311;}
         .error-input{border:1px solid red;}
         .error-text{color:red;font-size:13px;}
         .btn{width:100%;padding:12px;background:#FCA311;border:none;border-radius:8px;color:#000;font-weight:bold;cursor:pointer;}
         .footer{text-align:center;margin-top:10px;}
         .footer a{color:#FCA311;text-decoration:none;}
         .error-box{background:red;color:white;padding:10px;margin-bottom:15px;border-radius:8px;}
         .success-box{background:green;color:white;padding:10px;margin-bottom:15px;border-radius:8px;}
      </style>
   </head>
   <body>
      <div class="container">
         <h2>Reset Password</h2>
         {{-- success message --}}
         @if (session('status'))
         <div class="success-box">
            {{ session('status') }}
         </div>
         @endif
         {{-- errors --}}
         @if ($errors->any())
         <div class="error-box">
            <ul>
               @foreach ($errors->all() as $error)
               <li>{{ $error }}</li>
               @endforeach
            </ul>
         </div>
         @endif
         <form method="POST" action="/resetpassword">
            @csrf
            <div class="input-group">
               <label>Email</label>
               <input 
                  type="email" 
                  name="email" 
                  value="{{ old('email') }}"
                  class="@error('email') error-input @enderror"
                  >
               @error('email')
               <span class="error-text">{{ $message }}</span>
               @enderror
            </div>
            <button type="submit" class="btn">Send Password</button>
         </form>
         <div class="footer">
            <a href="/login">Back to Login</a>
         </div>
      </div>
   </body>
</html>