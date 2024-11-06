<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Quiz;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Package;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class StudentController extends Controller
{
    public function showDashboard()
    {
        $user = Auth::user();
    $quizzes = Quiz::with('tags', 'package')->paginate(10); 
    $packages = Package::with('quizzes')->paginate(10);   
        return view('student.dashboard', [
            'studentName' => $user ? $user->firstname : 'Unknown Student',
            'quizzes' => $user ? $quizzes : [],
            'packages'=>$packages,
        ]);
    }

    public function showQuestion($quiz_id, $question_number)
    {
        $quiz = Quiz::findOrFail($quiz_id);

        // Fetch the question and its answers based on the quiz and question number
        $question = Question::with('answers')
            ->where('quiz_id', $quiz_id)
            ->where('question_number', $question_number)
            ->firstOrFail();

        $userAnswer = DB::table('answers')
            ->where('question_id', $question->id)
            ->first();

        $userSelectedAnswer = session("answer.{$quiz_id}.{$question->id}");

        $totalTime = $quiz->time_duration * 60; // in seconds
        $timeRemaining = session("remaining_time", $totalTime);

        $totalQuestions = Question::where('quiz_id', $quiz_id)->count();

        // Calculate solved questions by joining with `questions`
        $solvedQuestions = DB::table('answers')
            ->join('questions', 'answers.question_id', '=', 'questions.id')
            ->where('questions.quiz_id', $quiz_id)
            ->distinct('answers.question_id')
            ->count();

        $unsolvedQuestions = $totalQuestions - $solvedQuestions;

        $nextQuestionNumber = $question_number < $totalQuestions ? $question_number + 1 : null;
        $prevQuestionNumber = $question_number > 1 ? $question_number - 1 : null;

        return view('student.question_detail', compact(
            'quiz', 'question', 'userSelectedAnswer', 'userAnswer',
            'timeRemaining', 'totalTime', 'totalQuestions',
            'solvedQuestions', 'unsolvedQuestions', 'nextQuestionNumber', 'prevQuestionNumber'
        ));
    }

    public function submitAnswer(Request $request, $questionId)
    {
        $answerId = $request->input('answer');
        $existingAnswer = DB::table('answers')
            ->where('question_id', $questionId)
            ->first();

        if (!$existingAnswer) {
            DB::table('answers')->insert([
                'question_id' => $questionId,
                'answer_id' => $answerId,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        $quizId = Question::find($questionId)->quiz_id;
        $totalQuestions = Question::where('quiz_id', $quizId)->count();

        $solvedQuestions = DB::table('answers')
            ->join('questions', 'answers.question_id', '=', 'questions.id')
            ->where('questions.quiz_id', $quizId)
            ->distinct('answers.question_id')
            ->count();

        $unsolvedQuestions = $totalQuestions - $solvedQuestions;

        return response()->json([
            'success' => true,
            'solvedQuestions' => $solvedQuestions,
            'unsolvedQuestions' => $unsolvedQuestions
        ]);
    }

    public function showExamSummary($quizId)
    {
        $totalQuestions = Question::where('quiz_id', $quizId)->count();

        $userAnswers = DB::table('answers')
            ->join('questions', 'answers.question_id', '=', 'questions.id')
            ->where('questions.quiz_id', $quizId)
            ->where('answers.user_id', Auth::id())
            ->get();

        $totalAttempt = $userAnswers->count();
        $totalCorrect = $userAnswers->where('is_correct', true)->count();

        $percentage = $totalQuestions > 0 ? ($totalCorrect / $totalQuestions) * 100 : 0;

        $solvedQuestions = $userAnswers
            ->filter(fn($answer) => $answer->is_correct)
            ->pluck('question_id')
            ->toArray();

        $unsolvedQuestions = Question::where('quiz_id', $quizId)
            ->whereNotIn('id', $solvedQuestions)
            ->pluck('question_text')
            ->toArray();

        return view('student.exam_summary', compact(
            'totalQuestions', 'totalAttempt', 'totalCorrect',
            'percentage', 'solvedQuestions', 'unsolvedQuestions'
        ));
    }
    public function showViews($packageName, Request $request)
    {
        $imageUrl = $request->query('imageUrl', asset('images/default.png')); // Provide a default image path
        $student = Student::first();
        $user = Auth::user();

        // Fetch the package by name to get its ID
        $package = Package::where('name', $packageName)->first();

        // Check if the package exists
        if (!$package) {
            return redirect()->back()->withErrors(['Package not found.']);
        }

        // Fetch quizzes related to the package
        $packageQuizzes = Quiz::where('package_id', $package->id)->get();

        return view('student.examview', [
            'studentName' => $user ? $user->firstname : 'Unknown Student',
            'packageName' => $package->name,
            'imageUrl' => $imageUrl,
            'packageQuizzes' => $packageQuizzes,
            'packagePrice' => $package->price,
            'package' => $package,
        ]);
    }
    public function showAvailableExams(Request $request)    
    {
        $student = auth()->user(); // or however you get the current student
        
        // Check if the user is authenticated
        if (!$student) {
            return redirect()->route('login'); // Redirect if not authenticated
        }
    
        $studentName = $student->name; 
        $packageId = $request->query('package_id'); 

    // Fetch quizzes associated with the package and ensure the package_id is not null
    $quizzes = Quiz::where('package_id', '!=', null)
                   ->with('tags')
                   ->paginate(10);
         return view('student.available_exams', compact('studentName', 'quizzes'));
    }
    public function scopeActive($query)
{
    return $query->where('active', 1); // Adjust the column and value as necessary
}

}