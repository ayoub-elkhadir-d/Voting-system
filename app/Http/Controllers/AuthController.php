<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{

    public function showRegister()
    {
        return view('auth.register');
    }


    public function showLogin()
    {
        return view('auth.login');
    }
  public function showReset()
    {
        return view('auth.reset');
    }


    public function login(Request $request)
    {
        $login = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($login)) {
            $request->session()->regenerate();
            return redirect('/dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');

        // return $request;
    }

    public function dashboard()
    {
        return view('auth.dashboard');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

      $user =  User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect('/')->with('success', 'Registration successful!');
    }

    public function login_link(Request $request)
    {
      
    $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()
            ->withErrors(['name' => 'Email not have a account.']);
        }

        $request->validate(['email' => 'required|email']);

 
        $token = Str::random(64);

       
        $user->remember_token = $token;
       
        $user->save();


       

        Mail::raw(url('/login-link/' . $token), function ($message) use ($request) {
            $message->to($request->email)->subject('login link ');
        });

        return back()->with('success', 'link sent');
    }

  

public function verify($token)
{
    $user = User::where('remember_token', $token)
                ->first();

    if (!$user) {
        return back()
            ->withErrors(['name' => 'Invalid or expired link!']);
       
    }

   
    Auth::login($user);

  
    $user->remember_token = null;
    $user->save();

    return redirect('/dashboard');
}
}
