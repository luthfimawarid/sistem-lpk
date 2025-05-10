<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('siswa.login.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        $user = User::where('email', $request->email)->first();
    
        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user); // 👈 inilah yang aktifkan Auth::check() dan Auth::id()
        
            return $user->role === 'admin' 
                ? redirect()->route('admin.dashboard')
                : redirect()->route('siswa.dashboard');
        }
    
        return back()->withErrors(['login' => 'Email atau password salah']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
    
}
