{{-- resources/views/exams/available_exams.blade.php --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Exams</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    
    <style>
        body {
            font-family: 'Arial', sans-serif;
        }

        .sidebar {
            height: 100vh;
            width: 200px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #f8f9fa;
            padding-top: 20px;
        }

        .sidebar a {
            padding: 10px 15px;
            text-decoration: none;
            font-size: 18px;
            color: #333;
            display: block;
        }

        .sidebar a:hover {
            background-color: #007bff;
            color: white;
        }

        .content {
            margin-left: 220px;
            padding: 20px;
        }

        .top-bar {
            background-color: #007bff;
            padding: 10px;
            color: white;
            display: flex;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .card {
            margin: 10px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease;
            background-color: white;
            overflow: hidden;
        }

        .card:hover {
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
        }

        .badge-available {
            border: 1px solid #008631;
            padding: 3px 5px;
            font-size: 12px;
            border-radius: 12px;
            display: inline-block;
            margin-right: 3px;
            color: #008631;
        }
    </style>
</head>

<body>

<div class="sidebar">
    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <i class="fas fa-list"></i> Exam List
    </a>
    <a href="#" class="{{ request()->routeIs('live.exam') ? 'active' : '' }}">
        <i class="fas fa-play-circle"></i> Live Exam
    </a>
    <a href="{{ route('result') }}" class="{{ request()->routeIs('result') ? 'active' : '' }}">
        <i class="fas fa-poll"></i> Results
    </a>
    <a href="{{ route('profile') }}" class="{{ request()->routeIs('profile') ? 'active' : '' }}">
        <i class="fas fa-user"></i> Profile
    </a>
</div>

<div class="content">
    <!-- Top Bar -->
    <div class="top-bar">
        <h3>APS KLC TRAIL EXAM</h3>
        <div class="user-icon">
            <div class="user-info">
                <div class="user-name">
                    <span>{{ $studentName }}</span>
                    <i class="fas fa-user-circle"></i>
                </div>
                <span class="role">Student</span> 
            </div>
            <div class="hover-menu">
                <a href="{{ route('profile') }}">Profile</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <a href="#" class="nav-link" id="logout-button" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
    </div>

    <h2 class="mt-4"><strong>Available Exams</strong></h2>
    <div class="exam-list d-flex flex-wrap">
        @if ($quizzes->isEmpty())
            <p>No available exams with packages at this time. Please check back later.</p>
        @else
            @foreach ($quizzes as $quiz)
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">{{ $quiz->heading }}</h5>
                        @if($quiz->photo)
                            <img src="/storage/{{ $quiz->photo }}" alt="{{ $quiz->heading }}" width="50" height="50" class="me-2">
                        @else
                            <img src="/images/exam_logo.png" alt="Exam Logo" width="50" height="50" class="me-2">
                        @endif
                        <h6><strong>{{ $quiz->sub_heading }}</strong></h6>  
                        <div>
                            Price: {{ $quiz->price ? '$' . $quiz->price : 'Free' }}<br>
                            Duration: {{ $quiz->time_duration }} minutes
                        </div>                      
                        @if($quiz->tags)
                            @foreach ($quiz->tags as $tag)
                                <span class="rounded-badge">{{ $tag->name }}</span>
                            @endforeach
                        @endif
                        <br><br>
                        <span class="badge-available">{{ $quiz->active ? 'Available' : 'Unavailable' }}</span>
                        @if($quiz->active)
                            <a href="{{ route('exam', ['examTitle' => $quiz->heading]) }}" class="btn btn-primary mt-2">START EXAM</a>
                        @endif                    
                    </div>
                </div>
            @endforeach
        @endif
    </div>    
    
    {{-- Pagination Links --}}
    <div class="pagination" style="margin-top: 20px;">
        {{ $quizzes->links() }}
        <p>Showing {{ $quizzes->firstItem() }} to {{ $quizzes->lastItem() }} of {{ $quizzes->total() }} exams</p>
    </div>
</div>    

</body>
</html>
