<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Summary</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Top Bar -->
    <div class="bg-blue-500 text-white text-center py-4">
        <h2 class="text-xl font-bold">Exam Ended - Exam Summary</h2>
    </div>

    <!-- Content Container -->
    <div class="flex justify-center items-center min-h-screen px-4">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-4xl">
            <div class="p-4 text-center">
                <h3 class="text-2xl font-semibold mb-4">Congratulation, Exam Ended</h3>
                <div class="bg-white border rounded-lg shadow-sm p-4">
                    <div class="text-right mb-4">
                        <p>Name: <strong>{{ $user->firstname }}</strong></p>
                        <p>ExamId: <strong>{{ $user->exam_id ?? 'N/A' }}</strong></p>
                    </div>
                    <div class="grid grid-cols-2 gap-4 text-left">
                        <p>Total Questions</p>
                        <p class="text-right">{{ $examDetails['totalQuestions'] }}</p>
                        <p>Total Attempt</p>
                        <p class="text-right">{{ $examDetails['totalAttempt'] }}</p>
                        <p>Total Correct</p>
                        <p class="text-right">{{ $examDetails['totalCorrect'] }}</p>
                        <p>Your Percentage</p>
                        <p class="text-right">{{ number_format($examDetails['percentage'], 2) }}%</p>
                    </div>
                </div>
            </div>
            
            <!-- Solved and Unsolved Questions -->
            <div class="mt-8">
                <h4 class="text-xl font-semibold mb-4 text-center">Questions Overview</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Solved Questions -->
                    <div class="bg-green-100 p-4 rounded-lg shadow-sm">
                        <h5 class="text-lg font-semibold text-green-700">Solved Questions</h5>
                        <ul class="list-disc pl-6">
                            @foreach($solvedQuestions as $question)
                                <li>{{ $question }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <!-- Unsolved Questions -->
                    <div class="bg-red-100 p-4 rounded-lg shadow-sm">
                        <h5 class="text-lg font-semibold text-red-700">Unsolved Questions</h5>
                        <ul class="list-disc pl-6">
                            @foreach($unsolvedQuestions as $question)
                                <li>{{ $question }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <div class="flex justify-center gap-4 mt-4">
                <a href="#" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">VIEW RESULT</a>
                <a href="#" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">RESULTS LIST</a>
                <a href="{{route('student.dashboard')}}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">BACK TO MAIN PAGE</a>
            </div>
        </div>
    </div>
</body>
</html>
