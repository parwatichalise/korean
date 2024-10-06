<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index(){
        return view('user.register');
    }

    public function store(Request $request): RedirectResponse
    {
        // Validate the incoming request
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'username' => 'required|string|unique:users,username',
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'contact' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Create the user with the role set to 'user'
        User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'username' => $request->username,
            'email' => $request->email,
            'contact' => $request->contact,
            'password' => Hash::make($request->password), // Hash the password
            'role' => 'user', // Set role to 'user' by default
        ]);

        // Redirect to a desired location (e.g., login page or user dashboard)
        return redirect()->route('login')->with('success', 'Registration successful. You can now log in.');
    }
}
