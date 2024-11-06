<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Models\Result;
use App\Models\Question;
use App\Models\User;
use App\Models\Quiz;

use Illuminate\Support\Str; 

class ExamController extends Controller
{
    public function exam($examTitle)
    {
        $user = Auth::user();
        $examId = 'N/A';

        // Generate or fetch existing exam ID for the user
        if ($user) {
            if (!$user->exam_id) {
                $examId = $this->generateExamId($user);
                $user->exam_id = $examId;
                $user->save(); 
            } else {
                $examId = $user->exam_id;
            }
        }

        return view('student.exam', [
            'studentName' => $user ? $user->firstname : 'Unknown Student',
            'examTitle' => $examTitle, 
            'examId' => $examId,
        ]);
    }
    private function generateExamId($user)
    {
        return 'EXAM-' . $user->id . strtoupper(Str::random(3));
    }
    public function startExam($examTitle)
    {
        $user = Auth::user(); 
        $quiz = Quiz::where('heading', $examTitle)->first();
        if (!$quiz) {
            return redirect()->back()->withErrors(['message' => 'Quiz not found.']);
        }

        $quizId = $quiz->id;
        $questions = Question::where('quiz_id', $quizId)->get();

        $totalQuestions = $questions->count();
        $solvedQuestions = 0;         
        $unsolvedQuestions = $totalQuestions - $solvedQuestions;

        $packageName = "Your Package Name"; 
        $imageUrl = "path/to/image.png"; 

        return view('student.exam_start', [
            'studentName' => $user->firstname,
            'examTitle' => $examTitle, 
            'questions' => $questions,
            'totalQuestions' => $totalQuestions,  
            'solvedQuestions' => $solvedQuestions, 
            'unsolvedQuestions' => $unsolvedQuestions, 
            'packageName' => $packageName,
            'imageUrl' => $imageUrl,
            'timeLimitInSeconds' => $quiz->time_limit_in_seconds,]);
    }
    public function result(Request $request)
    {
        $request->validate([
            'examTitle' => 'required|string',
            'score' => 'required|integer',
            'examId' => 'required|string',
        ]);

        $examTitle = $request->input('examTitle');
        $score = $request->input('score'); 

        $user = Auth::user();
        if ($user) {
            $result = new Result();
            $result->user_id = $user->id;
            $result->exam_id = $request->input('examId'); 
            $result->score = $score;
            $result->save();
        }

        return redirect()->route('student.result', ['examTitle' => $examTitle, 'score' => $score]);
    }

    public function showQuestion($id)
    {
        $question = Question::findOrFail($id);

        return view('student.show_question', compact('question'));
    }

    public function showExam($examTitle)
    {
        $quiz = Quiz::where('heading', $examTitle)->first();

        if (!$quiz) {
            return redirect()->back()->withErrors(['message' => 'Quiz not found.']);
        }

        $totalQuestions = strcasecmp(trim($examTitle), 'Color Vision Test') === 0 ? 20 : 40;

        $solvedQuestions = 0; // Replace this with the actual count of solved questions
        $unsolvedQuestions = $totalQuestions - $solvedQuestions;

        return view('student.show_exam', [
            'quiz' => $quiz,
            'totalQuestions' => $totalQuestions,
            'solvedQuestions' => $solvedQuestions,
            'unsolvedQuestions' => $unsolvedQuestions,
            'examTitle' => $examTitle,
        ]);
    }
    // Example Controller: PaymentController.php
public function success(Request $request)
{
    // Logic to handle successful payment

    // Fetch the user and update access for the purchased package
    $user = Auth::user();
    $packageName = $request->input('package_name');  // package name from payment form

    // Add code here to save the package purchase in the database for the user
    // e.g., by creating a new entry in a "user_packages" table that tracks purchases

    return redirect()->route('exam.dashboard')->with('status', 'Package purchased successfully!');
}

}
