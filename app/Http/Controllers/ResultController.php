<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class ResultController extends Controller
{
    public function showResult()
    {
        // Fetch the first student for testing
        $student = Student::first();

        // Pass student's name to the view
        if ($student) {
            return view('student.result', ['studentName' => $student->name]);
        } else {
            return view('student.result', ['studentName' => 'Unknown Student']);
        }
    }
}
