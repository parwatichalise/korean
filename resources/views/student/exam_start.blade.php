<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .exam-header {
            background-color: #2196F3;
            color: white;
            padding: 15px;
            font-size: 18px;
        }
        .container-box {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }
        .question-box {
            border: 1px solid #007bff;
            padding: 15px;
            margin: 5px;
            text-align: center;
            cursor: pointer;
            border-radius: 5px;
            font-size: 18px;
            flex: 1 0 20%;
        }
        .question-box:hover {
            background-color: #e0f7fa;
        }
        .question-container {
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
            border: 1px solid black;
        }
        .question-section-title {
            font-size: 20px;
            margin-bottom: 15px;
            text-align: center;
            color: #333;
        }
        .questions-wrapper {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }
        .time-remaining {
            font-weight: bold;
            color: #ff5722;
        }
        .btn-submit {
            margin-top: 10px;
        }
        .alert-info {
            font-size: 16px;
        }
        .no-underline {
            text-decoration: none;
            color: inherit;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="exam-header d-flex justify-content-between align-items-center">
        <h3>APS-KLC UBT Trail Exam</h3>
        <div class="user-name">
            <span>{{ auth()->user()->username }}</span> <!-- Display logged-in user's name -->
            <i class="fas fa-user-circle"></i>
        </div>
    </div>

    <h3 class="text-center">Exam Title: {{ $examTitle }}</h3>

    <!-- Main Container -->
    <div class="container container-box">
        <!-- Info Bar -->
        <div class="row">
            <div class="col-md-3">
                <div class="alert alert-info text-center">
                    Total Questions: <strong>{{ $totalQuestions }}</strong>
                </div>
            </div>
            <div class="col-md-3">
                <div class="alert alert-info text-center">
                    Solved: <strong>{{ $solvedQuestions }}</strong>
                </div>
            </div>
            <div class="col-md-3">
                <div class="alert alert-info text-center">
                    Unsolved: <strong>{{ $unsolvedQuestions }}</strong>
                </div>
            </div>
            <div class="col-md-3">
                <div class="alert alert-info text-center">
                    Time Remaining: <strong class="time-remaining" id="time-remaining"></strong>
                </div>
            </div>
        </div>

      
       <!-- Reading Questions Section -->
<!-- Row for Reading and Listening Questions Side by Side -->
<div class="row">
   
    <div class="col-md-6">
        <div class="question-container">
            <h5 class="question-section-title">Reading Questions</h5>
            <div class="questions-wrapper">
                @for ($i = 1; $i <= 20; $i++)
                    @php
                        $question = $questions->where('question_number', $i)->first();
                    @endphp
                    <div class="question-box">
                        @if ($question)
                            <a href="{{ route('student.showQuestion', ['quiz_id' => $question->quiz_id, 'question_number' => $question->question_number]) }}" class="btn">
                                {{ $i }}
                            </a>
                        @else
                            <span class="btn disabled">{{ $i }}</span>
                        @endif
                    </div>
                @endfor
            </div>
        </div>
    </div>
  
    <!-- Listening Questions Section -->
    <div class="col-md-6">
        <div class="question-container">
            <h5 class="question-section-title">Listening Questions</h5>

            @if (strcasecmp(trim($examTitle), 'Color Vision Test') === 0)
                <div class="d-flex justify-content-center align-items-center" style="height: 150px;">
                    No Listening Questions
                </div>
            @else
                <div class="questions-wrapper">
                    @foreach ($questions as $question)
                        @if (!empty($question->question_sound)) <!-- Check if there's a sound for the question -->
                            <div class="question-box" data-bs-toggle="collapse" data-bs-target="#question-details-{{ $question->id }}" aria-expanded="false" aria-controls="question-details-{{ $question->id }}">
                                {{ $question->question_number }}.
                            </div>
                            <div class="collapse" id="question-details-{{ $question->id }}">
                                <div class="card card-body">
                                    <p><strong>Question {{ $question->question_number }}:</strong> {{ $question->question_text }}</p>
                                    <audio controls>
                                        <source src="{{ asset($question->question_sound) }}" type="audio/mpeg"> <!-- Use the correct audio MIME type -->
                                        Your browser does not support the audio element.
                                    </audio>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>



        <!-- Submit Button -->
        <div class="d-flex justify-content-end">
            <form method="GET" action="{{ route('exam.summary') }}">
                <button class="btn btn-primary btn-submit" id="submit-button">Submit and Finish Exam</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Timer Countdown
        function startTimer(duration, display) {
            let timer = duration, minutes, seconds;
            const interval = setInterval(function () {
                minutes = parseInt(timer / 60, 10);
                seconds = parseInt(timer % 60, 10);
    
                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;
    
                display.textContent = minutes + ":" + seconds;
    
                if (--timer < 0) {
                    clearInterval(interval);
                    alert("Time's up! Your exam will be submitted.");
                    document.getElementById("submit-button").click(); // Auto-submit when time runs out
                }
            }, 1000);
        }
    
        window.onload = function () {
            let timeLimit = {{ $timeLimitInSeconds }}; // Time limit in seconds from backend
            let display = document.querySelector('#time-remaining');
            startTimer(timeLimit, display);
        };
    </script>    
</body>
</html>
