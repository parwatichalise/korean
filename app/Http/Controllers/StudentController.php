<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function showDashboard()
    {
        // Fetch the currently authenticated user
        $user = Auth::user();
    
        // Check if the user is logged in
        if ($user) {
            // Pass the user's first name to the view
            return view('student.dashboard', ['studentName' => $user->firstname]);
        } else {
            // If no user is logged in, return a fallback
            return view('student.dashboard', ['studentName' => 'Unknown Student']);
        }
    }
    
}
