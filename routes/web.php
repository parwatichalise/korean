<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\ViewExamController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::get('/',[LoginController::class,'index'])->name('login');
Route::post('/admin/login',[LoginController::class,'store'])->name('login.store');

Route::middleware(['auth'])->group(function () {
Route::middleware(['admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
});
//logout controller
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

//Profile Editing
Route::put('/admin/update-profile', [ProfileController::class, 'updateProfile'])->name('admin.updateProfile');



//Register Controller
Route::get('/register',[RegisterController::class,'index'])->name('register');

//UserController
Route::get('/user',[UserController::class,'index'])->name('user');
Route::post('/register', [RegisterController::class, 'store']);
Route::get('/users', [UserController::class, 'list'])->name('user.list');

//student controller
Route::get('/student/dashboard', [StudentController::class, 'showDashboard'])->name('student.dashboard');
Route::get('/show/dashboard', [StudentController::class, 'showDashboard'])->name('dashboard');

//ExamControlller
Route::get('/exam/{examTitle}', [ExamController::class, 'exam'])->name('exam');

//Profile Controller
Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

//Result Controller
Route::get('/result', [ResultController::class, 'showResult'])->name('result');


//ViewExamController
Route::get('/examview/{packageName}', [ViewExamController::class, 'showViews'])->name('examview');

// Authentication routes for teacher
Route::middleware(['auth'])->group(function () {
    // Teacher routes
    Route::get('/teacher/profile', function () {
        return view('teacher.profile'); 
    })->name('teacher.profile');

    Route::get('/teacher/dashboard', function () {
        return view('teacher.dashboard'); 
    })->name('teacher.dashboard');

    Route::resource('quizzes', QuizController::class);
    Route::resource('questions', QuestionController::class);
    Route::get('/questions/{quizId}/fetch', [QuestionController::class, 'fetchQuestions'])->name('questions.fetch');
    Route::resource('tags', TagController::class);
});
  // Exam routes
  Route::get('/exam/{examTitle}', [ExamController::class, 'exam'])->name('exam');
  Route::get('/exam/start/{examTitle}', [ExamController::class, 'startExam'])->name('start.exam');
  Route::post('/exam/result', [ExamController::class, 'result'])->name('result');

  
  //Route::get('/student/question/{quiz_id}/{question_number}', [StudentController::class, 'showQuestion'])->name('student.showQuestion');
  Route::get('/student/quiz/{quiz_id}/question/{question_number}', [StudentController::class, 'showQuestion'])->name('student.showQuestion');

  //next question
  Route::post('/quiz/{quizId}/question/next', [StudentController::class, 'nextQuestion'])->name('quiz.nextQuestion');




Route::post('/questions/{id}/answer', [QuestionController::class, 'submitAnswer'])->name('questions.answer');
Route::get('/questions/{id}', [QuestionController::class, 'show'])->name('questions.show');

//quiz time
Route::post('/quiz/{id}/save-time', [QuizController::class, 'saveTime'])->name('quiz.saveTime');

Route::get('/exam-summary', [StudentController::class, 'showExamSummary'])->name('exam.summary');























