<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use Illuminate\Support\Str; 

class ExamController extends Controller
{
    public function exam($examTitle) // Accept the exam title as a parameter
    {
        $user = Auth::user();

        // Initialize Exam ID
        $examId = 'N/A';

        // Generate Exam ID if user is authenticated
        if ($user) {
            $examId = $this->generateExamId($user);
        }

        // Pass student's name, exam title, and exam ID to the view
        return view('student.exam', [
            'studentName' => $user ? $user->firstname : 'Unknown Student',
            'examTitle' => $examTitle, // Pass the exam title
            'examId' => $examId, // Pass the generated Exam ID
        ]);
    }

    private function generateExamId($user)
    {
        // Example: Use user ID and a random 3-character string
        return 'EXAM-' . $user->id . strtoupper(Str::random(3));
    }
}
