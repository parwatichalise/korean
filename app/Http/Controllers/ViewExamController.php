<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class ViewExamController extends Controller
{
    public function showViews($packageName, Request $request)
    {
        // Retrieve imageUrl from query parameters
        $imageUrl = $request->query('imageUrl', 'default/path.png'); // Provide a default if necessary

        // Fetch the first student for testing
        $student = Student::first();
        $user = Auth::user();

        // Pass data to the view
        return view('student.examview', [
            'studentName' => $user ? $user->firstname : 'Unknown Student',
            'packageName' => $packageName,
            'imageUrl' => $imageUrl,
        ]);
    }
}
