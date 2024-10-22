<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Quiz;
use App\Models\option;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class StudentController extends Controller
{
    public function showDashboard()
    {
        // Fetch the currently authenticated user
        $user = Auth::user();
        
        // Fetch quizzes for the student
        $quizzes = Quiz::with('tags')->paginate(10);

        // Check if the user is logged in
        if ($user) {
            // Pass the user's first name and quizzes to the view
            return view('student.dashboard', [
                'studentName' => $user->firstname,
                'quizzes' => $quizzes
            ]);
        } else {
            // If no user is logged in, return a fallback
            return view('student.dashboard', [
                'studentName' => 'Unknown Student',
                'quizzes' => [] // Pass an empty array for quizzes
            ]);
        }
    }
   
    
   /* public function showQuestion($quiz_id, $question_number)
    {
        // Fetch the quiz and the current question
        $quiz = Quiz::findOrFail($quiz_id);
    
        // Fetch the current question and its associated options
        $question = Question::with('options')
            ->where('quiz_id', $quiz_id)
            ->where('question_number', $question_number)
            ->firstOrFail();
    
        // Fetch the options for the current question
          $options = Option::where('question_id', $question->id)->get();

          $userId = auth::id();
          $userAnswer = DB::table('answers')
        ->where('user_id', $userId)
        ->where('question_id', $question->id)
        ->first();
    
        // Set up time limits and remaining questions logic (customize as needed)
        $totalTime = 600; // 10 minutes, adjust as needed
        $timeRemaining = $totalTime; // Modify based on your time logic
    
        // Fetch the total number of questions in the quiz
        $totalQuestions = Question::where('quiz_id', $quiz_id)->count();
    
        // Get the next and previous question numbers
        $nextQuestionNumber = $question_number < $totalQuestions ? $question_number + 1 : null;
        $prevQuestionNumber = $question_number > 1 ? $question_number - 1 : null;
    
        // Return the view with the necessary data
        return view('student.question_detail', compact('quiz', 'question', 'options', 'timeRemaining', 'nextQuestionNumber', 'prevQuestionNumber'));
    }*/
   
    public function showQuestion($quiz_id, $question_number)
    {
        // Fetch the quiz and the current question
        $quiz = Quiz::findOrFail($quiz_id);
    
        // Fetch the current question and its associated options
        $question = Question::with('options')->where('quiz_id', $quiz_id)
            ->where('question_number', $question_number)
            ->firstOrFail();
    
        // Fetch the user's answer for the current question
        $userAnswer = DB::table('answers')
            ->where('question_id', $question->id)
            ->first(); // This fetches the answer for the current question
    
        // Retrieve the user-selected answer from the session
        $userSelectedAnswer = session("answer.{$quiz_id}.{$question->id}");
    
        // Set up time limits and remaining questions logic
        $totalTime =1200; // 20 minutes
        $timeRemaining = $totalTime; // Modify based on your time logic
    
        // Fetch the total number of questions in the quiz
        $totalQuestions = Question::where('quiz_id', $quiz_id)->count();
    
        // Get the next and previous question numbers
        $nextQuestionNumber = $question_number < $totalQuestions ? $question_number + 1 : null;
        $prevQuestionNumber = $question_number > 1 ? $question_number - 1 : null;
    
        // Return the view with the necessary data
        return view('student.question_detail', [
            'quiz' => $quiz,
            'question' => $question,
            'options' => $question->options, // Using the relationship for options
            'userSelectedAnswer' => $userSelectedAnswer,
            'userAnswer' => $userAnswer,
            'timeRemaining' => $timeRemaining,
            'nextQuestionNumber' => $nextQuestionNumber,
            'prevQuestionNumber' => $prevQuestionNumber
        ]);

        
    }

    
    public function showExamSummary()
{
    $user = Auth::user();
    $examDetails = [
        'totalQuestions' => 20,
        'totalAttempt' => 1,
        'totalCorrect' => 0,
        'percentage' => 0.00,
    ];

    $solvedQuestions = ['Question 1', 'Question 3']; // Example solved questions
    $unsolvedQuestions = ['Question 2', 'Question 4']; // Example unsolved questions

    return view('student.exam_summary', compact('user', 'examDetails', 'solvedQuestions', 'unsolvedQuestions'));
}

}


    


    
/*public function nextQuestion(Request $request, $quizId)
{
    $currentQuestionNumber = $request->input('current_question_number');

    // Fetch the next question based on the current question number
    $nextQuestion = Question::where('quiz_id', $quizId)
                            ->where('question_number', $currentQuestionNumber + 1) // Increment to get the next question
                            ->first();

    if ($nextQuestion) {
        $options = $nextQuestion->options; // Fetch options for the next question

        // Generate options HTML (if you still need to show options)
        $optionsHtml = view('student.question_detail', ['options' => $options])->render();

        return response()->json([
            'question' => $nextQuestion,
            'optionsHtml' => $optionsHtml // Only if you want to display options
        ]);
    }

    return response()->json(['message' => 'No more questions available.']);
}*/



