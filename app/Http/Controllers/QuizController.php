<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\Tag;
use App\Models\Package;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::with('tags')->paginate(10);
        // Check user's role to determine which view to return
        $view = Auth::user() && Auth::user()->role === 'admin' ? 'admin.list.quiz-list' : 'teacher.list.quiz-list';
        return view($view, compact('quizzes'));
    }

    public function create()
    {
        $tags = Tag::all(); // Fetch all tags to populate the tags select input
        $packages = Package::all(); // Fetch all packages to populate the select input

    // Check user's role to determine which view to return
    $view = Auth::user() && Auth::user()->role === 'admin' ? 'admin.create.quiz' : 'teacher.create.quiz';
    return view($view, compact('tags', 'packages'));       
    }

    public function store(Request $request)
    {
        $request->validate([
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'heading' => 'required|string|max:255',
            'sub_heading' => 'nullable|string|max:255',
            'price' => 'nullable|numeric',
            'time_duration' => 'required|string', 
            'active' => 'required|boolean',
            'tags' => 'required|array|exists:tags,id', // Validate selected tags exist
            'package_id' => 'nullable|exists:packages,id',
        ]);

        // Create a new quiz instance
        $quiz = new Quiz();
        
        // Handle photo upload
        if ($request->hasFile('photo')) {
            $quiz->photo = $request->file('photo')->store('quizzes', 'public');
        }
        
        // Fill quiz details from the request
        $quiz->fill($request->only('heading', 'sub_heading','price', 'time_duration', 'active', 'package_id'));
        $quiz->created_by = Auth::id(); 
        $quiz->package_id = $request->input('package_id');
        $quiz->save();

        // Attach tags to the quiz
        $quiz->tags()->attach($request->input('tags'));

        return redirect()->route('quizzes.index')->with('success', 'Quiz added successfully.');
    }

    public function edit(Quiz $quiz)
    {
        $tags = Tag::all(); // Fetch all tags for editing
        $packages = Package::all(); // Fetch all packages for the select input

        $view = Auth::user() && Auth::user()->role === 'admin' ? 'admin.edit.quiz-edit' : 'teacher.edit.quiz-edit';
        return view($view, compact('quiz', 'tags', 'packages'));
    }

    public function update(Request $request, Quiz $quiz)
    {
        $request->validate([
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'heading' => 'required|string|max:255',
            'sub_heading' => 'nullable|string|max:255',
            'price' => 'nullable|numeric',
            'time_duration' => 'required|string',
            'tags' => 'array|exists:tags,id', // Validate selected tags exist
            'active' => 'required|boolean',
            'package_id' => 'nullable|exists:packages,id',
        ]);

        // Handle photo upload and remove the old photo if necessary
        if ($request->hasFile('photo')) {
            if ($quiz->photo) {
                Storage::disk('public')->delete($quiz->photo); // Delete the old photo
            }
            $quiz->photo = $request->file('photo')->store('quizzes', 'public'); // Store the new photo
        }
    
        // Update quiz details
        $quiz->fill($request->only('heading','price', 'sub_heading','time_duration', 'active', 'package_id'));
        $quiz->save();
    
        // Sync tags if they are provided in the request
        if ($request->has('tags')) {
            $quiz->tags()->sync($request->input('tags'));
        }
    
        return redirect()->route('quizzes.index')->with('success', 'Quiz updated successfully.');
    }

    public function destroy(Quiz $quiz)
    {
        // Delete the associated photo if it exists
        if ($quiz->photo) {
            Storage::disk('public')->delete($quiz->photo);
        }

        // Delete the quiz
        $quiz->delete();
        return redirect()->route('quizzes.index')->with('success', 'Quiz deleted successfully.');
    }

    public function saveTime(Request $request, $quizId)
    {
        // Save remaining time in session
        session(['remaining_time' => $request->input('remaining_time')]);
        return response()->json(['status' => 'success']);
    }

    // Accessor to get time in seconds (assuming time_duration is stored in minutes)
    public function getTimeLimitInSecondsAttribute()
    {
        return $this->time_duration * 60; // Assuming time_duration is stored in minutes
    }
    public function show($id)
{
    $quiz = Quiz::with('tags')->findOrFail($id); // Fetch the quiz along with its tags
    return view('quizzes.show', compact('quiz')); // Pass the quiz to the view
}

}