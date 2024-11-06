<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $quiz->title }}</title> <!-- Ensure $quiz->title is passed correctly -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Adjust the height of the image */
        .question-image {
            max-width: 100%;
            height: auto;
            max-height: 300px;
            object-fit: contain;
        }

        /* Styling for the answer options */
        .answers ol {
            list-style: none;
            padding-left: 0;
        }

        .answers ol li {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .answers ol li input[type="radio"] {
            margin-right: 10px;
        }

        .question-content {
            display: flex;
        }

        .question-image-container {
            width: 40%; /* Adjust the width of the image section */
            padding-right: 20px;
        }

        .question-text-container {
            width: 60%; /* Adjust the width of the question and answer section */
        }
    </style>
</head>
<body class="bg-gray-100">

<div class="container mx-auto p-4">
    <div class="bg-blue-500 text-white p-2 rounded flex justify-between items-center">
        <div class="text-lg font-bold">{{ $quiz->title }}</div> <!-- Correct quiz title rendering -->
        <div class="text-right">Time Remaining: <span id="timer">00:00</span></div>
    </div>

    <div class="mt-4 bg-white p-4 rounded shadow">
        <div class="question-content">
            <!-- Left column for image -->
            @if ($question->question_image)
                <div class="question-image-container">
                    <img src="{{ asset('storage/' . $question->question_image) }}" alt="Question Image" class="question-image">
                </div>
            @endif

            <!-- Right column for question and options -->
            <div class="question-text-container">
                <h2 class="text-lg font-bold mb-4">Question {{ $question->question_number }}: {{ $question->question_text }}</h2>

                <!-- Options -->
                <div class="answers">
                    <form id="answer-form">
                        @csrf
                        <ol>
                            @foreach($question->answers as $answer)
                                <li>
                                    <input type="radio" name="answer" value="{{ $answer->id }}" 
                                           id="answer-{{ $answer->id }}"
                                           {{ $userAnswer && isset($userAnswer->answer_id) && $userAnswer->answer_id == $answer->id ? 'checked' : '' }}>
                                    <label for="answer-{{ $answer->id }}">{{ $loop->iteration }}. {{ $answer->answer_text }}</label>
                                </li>
                            @endforeach
                        </ol>
                        <button type="submit" class="bg-blue-500 text-white p-2 rounded mt-2">Submit Answer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Next and Previous buttons with total question button in the middle -->
    <div class="flex justify-between items-center mt-4">
        @if ($prevQuestionNumber)
            <a href="{{ route('student.showQuestion', ['quiz_id' => $quiz->id, 'question_number' => $prevQuestionNumber]) }}" class="bg-blue-500 text-white p-2 rounded">Previous</a>
        @else
            <button class="bg-gray-500 text-white p-2 rounded cursor-not-allowed" disabled>Previous</button>
        @endif
        <a href="{{ route('start.exam', ['examTitle' => $quiz->heading]) }}" class="btn btn-primary" type="button">Total Questions</a>
        @if ($nextQuestionNumber)
            <a href="{{ route('student.showQuestion', ['quiz_id' => $quiz->id, 'question_number' => $nextQuestionNumber]) }}" class="bg-blue-500 text-white p-2 rounded">Next</a>
        @else
            <button class="bg-gray-500 text-white p-2 rounded cursor-not-allowed" disabled>Next</button>
        @endif
    </div>

    <!-- Solved and Unsolved Counts -->
    <div class="progress mt-4">
        <p>Total Questions: {{ $totalQuestions }}</p>
        <p>Solved: {{ $solvedQuestions }}</p>
        <p>Unsolved: {{ $unsolvedQuestions }}</p>
    </div>    
</div>

<script>
    // Initialize timer
    var timeRemaining = {{ $timeRemaining }};
    var totalTime = {{ $totalTime }};

    function startTimer() {
        var timerInterval = setInterval(function() {
            if (timeRemaining <= 0) {
                clearInterval(timerInterval);
                alert("Time is up!"); // Notify user that time is up
                // Optionally, you could submit the quiz or redirect here
            } else {
                timeRemaining--;
                var minutes = Math.floor(timeRemaining / 60);
                var seconds = timeRemaining % 60;
                document.getElementById('timer').innerHTML = minutes + ":" + (seconds < 10 ? '0' + seconds : seconds);
            }
        }, 1000);
    }

    // Start the timer when the page loads
    window.onload = startTimer;

    // Handle answer submission via AJAX
    document.getElementById('answer-form').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const url = "{{ route('questions.answer', $question->id) }}"; // Adjust to your route

        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': formData.get('_token'),
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update solved and unsolved question counts
                document.getElementById('solved-count').innerText = data.solvedQuestions;
                document.getElementById('unsolved-count').innerText = data.unsolvedQuestions;
            } else {
                alert('Error submitting answer.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
</script>

</body>
</html>
