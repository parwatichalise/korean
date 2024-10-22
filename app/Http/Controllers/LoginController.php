<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth; 



class LoginController extends Controller
{
    public function index(){
        return view('admin.login');
    }

   
    public function store(Request $request): RedirectResponse
    {
        // Validate the incoming request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
    
            // Check the role of the authenticated user
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard'); // Redirect to admin dashboard
            } elseif (Auth::user()->role === 'user' || Auth::user()->role === 'student') {
                return redirect()->route('student.dashboard'); // Redirect to user page
            } elseif (Auth::user()->role === 'teacher') {
                return redirect()->route('teacher.profile'); // Redirect to teacher dashboard
            }
        }
        return redirect()->route('login')->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
