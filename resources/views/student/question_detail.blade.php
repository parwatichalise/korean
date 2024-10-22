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
                    <form action="{{ route('questions.answer', $question->id) }}" method="POST">
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

        <!-- Button displaying total number of questions -->
        <a href="{{url('exam/start/question') }}">
        <button class="bg-blue-400 text-black p-2 rounded cursor-default">
            Total Questions: {{ $quiz->total_questions }}
        </button>
    </a>

        @if ($nextQuestionNumber)
            <a href="{{ route('student.showQuestion', ['quiz_id' => $quiz->id, 'question_number' => $nextQuestionNumber]) }}" class="bg-blue-500 text-white p-2 rounded">Next</a>
        @else
            <button class="bg-gray-500 text-white p-2 rounded cursor-not-allowed" disabled>Next</button>
        @endif
    </div>
</div>

<script>
    // Set total time for the quiz (20 minutes = 1200 seconds)
    let timeRemaining = localStorage.getItem('quiz-{{ $quiz->id }}-timeRemaining');

    // Debug: Log the retrieved time from localStorage
    console.log('Retrieved time from localStorage:', timeRemaining);

    // If timeRemaining is not found in localStorage (first question load), initialize it with 1200 seconds (20 minutes)
    if (timeRemaining === null) {
        timeRemaining = 1200;  // 20 minutes
        console.log('Initial time from server:', timeRemaining);
    } else {
        timeRemaining = parseInt(timeRemaining);  // Convert to an integer
        console.log('Parsed time from localStorage:', timeRemaining);
    }

    const timerElement = document.getElementById('timer');
    let fifteenMinuteAlertShown = false;  // To ensure the alert only shows once

    function startTimer() {
        const interval = setInterval(() => {
            const minutes = Math.floor(timeRemaining / 60);
            const seconds = timeRemaining % 60;
            timerElement.textContent = minutes + ':' + (seconds < 10 ? '0' : '') + seconds;

            // Alert when the time reaches 15 minutes (900 seconds remaining)
            if (timeRemaining === 900 && !fifteenMinuteAlertShown) {
                alert('You have 15 minutes remaining.');
                fifteenMinuteAlertShown = true;  // Mark the alert as shown
            }

            if (timeRemaining <= 0) {
                clearInterval(interval);
                alert('Time is up! Submitting your answers.');
                // Optionally submit the form or redirect the user when time is up
            }

            timeRemaining--;

            // Save the updated remaining time back to localStorage
            localStorage.setItem('quiz-{{ $quiz->id }}-timeRemaining', timeRemaining);
            console.log('Saved time to localStorage:', timeRemaining);
        }, 1000);
    }

    startTimer();
</script>

</body>
</html>
