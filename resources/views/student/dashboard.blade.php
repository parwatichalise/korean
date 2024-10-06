<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EPS-TOPIK UBT Trail Exam</title>
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
            width: 22.5%;
            border: 1px solid #ddd; /* Light grey border similar to the image */
            border-radius: 10px; /* Rounded corners */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Light shadow effect */
            transition: box-shadow 0.3s ease; /* Smooth transition for hover effect */
            background-color: white; /* White background for card */
            overflow: hidden; 
        }

        .card:hover {
           box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15); /* Slightly darker shadow on hover */
       }

        .card img {
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }


        /* Badge for "Available" and "Available to Buy" */
        .badge-available,
        .badge-available-buy {
            border: 1px solid;
            padding: 3px 5px;
            font-size: 12px;
            border-radius: 12px;
            display: inline-block;
            margin-right: 3px;
        }

        .badge-available {
            color: #008631;
            border-color: #008631;
        }

        .badge-available-buy {
            color: #008631;
            border-color: #008631;
        }

        .buy-btn {
            background-color: #008631;
            color: white;
            font-size: 14px;
            border-radius: 5px;
            padding: 5px;
        }

        .btn-secondary{
            font-size: 14px;
            border-radius: 5px;
            padding: 5px;
            color: #00bfff;
            background-color: white;
            border-radius: 12px;
            border: 1px solid #00bfff;

        }

        .exam-list,
        .exam-packages {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .exam-header {
            text-align: center;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 10px;
        }

        .exam-card-header {
            text-align: center;
            padding: 5px;
            background-color: #e9ecef;
        }

        .rounded-badge {
            background-color: #f0f0f0;
            padding: 3px 8px;
            font-size: 12px;
            border-radius: 12px;
            display: inline-block;
        }

        .mt-4{
            color: #448EE4;
        }

        .active {
    background-color: skyblue; /* Adjust the color as needed */
    color: white; /* Adjust text color for contrast */
       }

       
       .profile-section {
            margin: 20px auto; /* Center align with auto margins */
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f8f9fa;
            max-width: 500px; /* Set max width for centering */
            position: relative; /* For absolute positioning of edit button */
        }

        .profile-section h3 {
            color: #007bff;
            text-align: center; /* Center title */
        }

        .profile-section .form-group {
            margin-bottom: 15px;
        }

        /* Styles for the hover menu */
        .hover-menu {
            display: none; /* Hide by default */
            position: absolute; /* Position relative to the dropdown */
            background-color: white; /* Background color for the dropdown */
            border: 1px solid #ddd; /* Border for the dropdown */
            z-index: 1000; /* Ensure it appears above other content */
            right: 0; /* Align it to the right */
            width: 150px; /* Width of the dropdown */
        }

        .user-icon:hover .hover-menu {
            display: block; /* Show on hover */
        }

        .hover-menu a {
            color: black; /* Color for dropdown items */
            padding: 10px; /* Padding for items */
            text-decoration: none; /* No underline */
            display: block; /* Block level */
        }

        .hover-menu a:hover {
            background-color: #007bff; /* Change color on hover */
            color: white; /* Text color on hover */
        }

        /* Align user icon and text */
        .user-info {
            display: flex;
            flex-direction: column; /* Stack elements vertically */
            align-items: flex-start; /* Align items to the left */
        }

        .user-info .user-name {
            display: flex; /* Use flexbox for name and icon */
            align-items: center; /* Center the icon with text */
        }

        .user-info .user-name span {
            margin-right: 8px; /* Space between text and icon */
        }

        .user-info .user-name .fas {
            font-size: 30px; /* Size of the Font Awesome icon */
        }

        /* To ensure alignment of the name and role */
        .user-info span.role {
            margin-left: 0px; /* Adjust margin to align with the name */
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
                    <i class="fas fa-user-circle"></i> <!-- Font Awesome user icon -->
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

        <!-- Available Exams Section -->
        <h2 class="mt-4"><strong>Available Exams</strong></h2>
        <div class="exam-list">
            <!-- Exam Cards (4 per row) -->
            <div class="card">
                <div class="exam-card-header">
                    <img src="/images/exam_logo.png" alt="EPS TOPIK" width="50" height="50">

                    <h6><strong>UBT-TEST</strong></h6>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Color Vision Test</h5>
                    <span class="rounded-badge">free_for_all</span>
                    <span class="rounded-badge">free_for_all</span>
                    <br><br><span class="badge-available">Available</span> <!-- Badge Updated -->
                    <a href="{{ route('exam', ['examTitle' => 'Color Vision Test']) }}" class="btn btn-primary mt-2">START EXAM</a> <!-- Dynamic link -->
                </div>
            </div>

            <div class="card">
                <div class="exam-card-header">
                    <img src="/images/exam_logo.png" alt="EPS TOPIK" width="50" height="50">

                    <h6><strong>UBT-TEST</strong></h6>
                </div>
                <div class="card-body">
                    <h5 class="card-title">UBT - 01 [무료]</h5>
                    <span class="rounded-badge">free_for_all</span>
                    <span class="rounded-badge">free_for_all</span>
                    <br><br><span class="badge-available">Available</span> <!-- Badge Updated -->
                    <a href="{{ route('exam', ['examTitle' => 'UBT - 01']) }}" class="btn btn-primary mt-2">START EXAM</a> <!-- Dynamic link -->
                </div>
            </div>

            <div class="card">
                <div class="exam-card-header">
                    <img src="/images/exam_logo.png" alt="EPS TOPIK" width="50" height="50">

                    <h6><strong>UBT-TEST</strong></h6>
                </div>
                <div class="card-body">
                    <h5 class="card-title">UBT - 02 [무료]</h5>
                    <span class="rounded-badge">free_for_all</span>
                    <span class="rounded-badge">free_for_all</span>
                    <br><br><span class="badge-available">Available</span> <!-- Badge Updated -->
                    <a href="{{ route('exam', ['examTitle' => 'UBT - 02']) }}" class="btn btn-primary mt-2">START EXAM</a>
                </div>
            </div>

            <div class="card">
                <div class="exam-card-header">
                    <img src="/images/exam_logo.png" alt="EPS TOPIK" width="50" height="50">

                    <h6><strong>UBT-TEST</strong></h6>
                </div>
                <div class="card-body">
                    <h5 class="card-title">UBT - 03 [무료]</h5>
                    <span class="rounded-badge">free_for_all</span>
                    <span class="rounded-badge">free_for_all</span>
                    <br><br><span class="badge-available">Available</span> <!-- Badge Updated -->
                    <a href="{{ route('exam', ['examTitle' => 'UBT - 03']) }}" class="btn btn-primary mt-2">START EXAM</a>
                </div>
            </div>
        </div>

        <!-- Exam Packages Section -->
        <h2 class="mt-4"><strong>Exam Packages</strong></h2>
        <div class="exam-packages">
            <!-- Package Cards (4 per row) -->

    <!--10 sets Package -->
            <div class="card">
                <div class="exam-card-header">
                    <img src="/images/package.png" alt="Package" width="50px">

                </div>
                <div class="card-body">
                    <h5 class="card-title">10 sets Package</h5>
                    <div>
                        <span class="badge-available">Available</span> <!-- Side-by-side badges -->
                        <span class="badge-available-buy">Available To Buy</span>
                    </div>
                    <p class="card-text">Includes 10 exams</p>
                    <a href="/buy/10-sets-package" class="btn buy-btn">BUY RS. 10</a> <!-- Link Added -->
                    <a href="{{ route('examview', ['packageName' => '10 sets Package', 'imageUrl' => 'images/package.png']) }}" class="btn btn-secondary">VIEW</a>
                </div>
            </div>


 <!--Chapter-wise Package -->
            <div class="card">
                <div class="exam-card-header">
                    <img src="/images/package.png" alt="Package" width="50px">

                </div>
                <div class="card-body">
                    <h5 class="card-title">Chapter-wise Package</h5>
                    <div>
                        <span class="badge-available">Available</span> <!-- Side-by-side badges -->
                        <span class="badge-available-buy">Available To Buy</span>
                    </div>
                    <p class="card-text">Includes 25 exams</p>
                    <a href="/buy/chapter-wise-package" class="btn buy-btn">BUY RS. 250</a> <!-- Link Added -->
                    <a href="{{ route('examview', ['packageName' => 'Chapter-wise Package', 'imageUrl' => 'images/package.png']) }}" class="btn btn-secondary">VIEW</a>  <!-- Link Added -->
                </div>
            </div>


<!-- Monthly Package -->

            <div class="card">
                <div class="exam-card-header">
                    <img src="/images/package.png" alt="Package" width="50px">

                </div>
                <div class="card-body">
                    <h5 class="card-title">Monthly Package</h5>
                    <div>
                        <span class="badge-available">Available</span> <!-- Side-by-side badges -->
                        <span class="badge-available-buy">Available To Buy</span>
                    </div>
                    <p class="card-text">Includes 50 exams</p>
                    <a href="/buy/monthly-package" class="btn buy-btn">BUY RS. 500</a> <!-- Link Added -->
                    <a href="{{ route('examview', ['packageName' => 'Monthly Package', 'imageUrl' => 'images/package.png']) }}" class="btn btn-secondary">VIEW</a>  <!-- Link Added -->
                </div>
            </div>


<!-- Full-year Package -->
            <div class="card">
                <div class="exam-card-header">
                    <img src="/images/package.png" alt="Package" width="50px">

                </div>
                <div class="card-body">
                    <h5 class="card-title">Full-year Package</h5>
                    <div>
                        <span class="badge-available">Available</span> <!-- Side-by-side badges -->
                        <span class="badge-available-buy">Available To Buy</span>
                    </div>
                    <p class="card-text">Includes 100 exams</p>
                    <a href="/buy/full-year-package" class="btn buy-btn">BUY RS. 1000</a> <!-- Link Added -->
                    <a href="{{ route('examview', ['packageName' => 'Full-year Package', 'imageUrl' => 'images/package.png']) }}" class="btn btn-secondary">VIEW</a> 
                </div>
            </div>


<!-- CBT - Food -->
            <div class="card">
                <div class="exam-card-header">
                    <img src="/images/package.png" alt="Package" width="50px">

                </div>
                <div class="card-body">
                    <h5 class="card-title">CBT - Food</h5>
                    <div>
                        <span class="badge-available">Available</span> <!-- Side-by-side badges -->
                        <span class="badge-available-buy">Available To Buy</span>
                    </div>
                    <p class="card-text">Includes 10 exams</p>
                    <a href="/buy/10-sets-package" class="btn buy-btn">BUY RS. 10</a> <!-- Link Added -->
                    <a href="{{ route('examview', ['packageName' => 'Full-year Package', 'imageUrl' => 'images/package.png']) }}" class="btn btn-secondary">VIEW</a>
                </div>
            </div>


<!-- CBT - Mechinery -->
            <div class="card">
                <div class="exam-card-header">
                    <img src="/images/package.png" alt="Package" width="50px">

                </div>
                <div class="card-body">
                    <h5 class="card-title">CBT - Mechinery</h5>
                    <div>
                        <span class="badge-available">Available</span> <!-- Side-by-side badges -->
                        <span class="badge-available-buy">Available To Buy</span>
                    </div>
                    <p class="card-text">Includes 25 exams</p>
                    <a href="/buy/chapter-wise-package" class="btn buy-btn">BUY RS. 250</a> <!-- Link Added -->
                    <a href="{{ route('examview', ['packageName' => 'CBT - Mechinery', 'imageUrl' => 'images/package.png']) }}" class="btn btn-secondary">VIEW</a>
                </div>
            </div>



<!-- CBT - Rubber/Plastic -->
            <div class="card">
                <div class="exam-card-header">
                    <img src="/images/package.png" alt="Package" width="50px">

                </div>
                <div class="card-body">
                    <h5 class="card-title">CBT - Rubber/Plastic</h5>
                    <div>
                        <span class="badge-available">Available</span> <!-- Side-by-side badges -->
                        <span class="badge-available-buy">Available To Buy</span>
                    </div>
                    <p class="card-text">Includes 25 exams</p>
                    <a href="/buy/chapter-wise-package" class="btn buy-btn">BUY RS. 250</a> <!-- Link Added -->
                    <a href="{{ route('examview', ['packageName' => 'CBT - Rubber & Plastic', 'imageUrl' => 'images/package.png']) }}" class="btn btn-secondary">VIEW</a>
                </div>
            </div>


<!-- CBT - Metal -->
            <div class="card">
                <div class="exam-card-header">
                    <img src="/images/package.png" alt="Package" width="50px">

                </div>
                <div class="card-body">
                    <h5 class="card-title">CBT - Metal</h5>
                    <div>
                        <span class="badge-available">Available</span> <!-- Side-by-side badges -->
                        <span class="badge-available-buy">Available To Buy</span>
                    </div>
                    <p class="card-text">Includes 100 exams</p>
                    <a href="/buy/full-year-package" class="btn buy-btn">BUY RS. 1000</a> <!-- Link Added -->
                    <a href="{{ route('examview', ['packageName' => 'CBT - Metal', 'imageUrl' => 'images/package.png']) }}" class="btn btn-secondary">VIEW</a>
                </div>
            </div>
        </div>


<!-- Other Packages Section -->
        <h2 class="mt-4"><strong>Other Packages</strong></h2>
        <div class="exam-packages">
            <!-- Package Cards (4 per row) -->
            <div class="card">
                <div class="exam-card-header">
                    <img src="/images/exam_logo.png" alt="EPS TOPIK" width="50" height="50">
                    <h6><strong>UBT-TEST</strong></h6>
                </div>
                <div class="card-body">
                    <h5 class="card-title">CBT - Food 1</h5>
                    <div>
                        <span class="badge-available-buy">cbt</span>
                        <span class="badge-available-buy">private</span>
                        <span class="badge-available">Available</span> <!-- Side-by-side badges -->
                    </div>
                    <p class="card-text">Price: Rs.100</p>
                    <a href="/buy/10-sets-package" class="btn buy-btn">BUY EXAM</a> <!-- Link Added -->
                </div>
            </div>

            <div class="card">
                <div class="exam-card-header">
                    <img src="/images/exam_logo.png" alt="EPS TOPIK" width="50" height="50">
                    <h6><strong>UBT-TEST</strong></h6>
                </div>
                <div class="card-body">
                    <h5 class="card-title">CBT - Food 2</h5>
                    <div>
                        <span class="badge-available-buy">cbt</span>
                        <span class="badge-available-buy">private</span>
                        <span class="badge-available">Available</span> <!-- Side-by-side badges -->
                    </div>
                    <p class="card-text">Price: Rs.100</p>
                    <a href="/buy/10-sets-package" class="btn buy-btn">BUY EXAM</a> <!-- Link Added -->
                </div>
            </div>

            <div class="card">
                <div class="exam-card-header">
                    <img src="/images/exam_logo.png" alt="EPS TOPIK" width="50" height="50">
                    <h6><strong>UBT-TEST</strong></h6>
                </div>
                <div class="card-body">
                    <h5 class="card-title">CBT - Food 3</h5>
                    <div>
                        <span class="badge-available-buy">cbt</span>
                        <span class="badge-available-buy">private</span>
                        <span class="badge-available">Available</span> <!-- Side-by-side badges -->
                    </div>
                    <p class="card-text">Price: Rs.100</p>
                    <a href="/buy/10-sets-package" class="btn buy-btn">BUY EXAM</a> <!-- Link Added -->
                </div>
            </div>

            <div class="card">
                <div class="exam-card-header">
                    <img src="/images/exam_logo.png" alt="EPS TOPIK" width="50" height="50">
                    <h6><strong>UBT-TEST</strong></h6>
                </div>
                <div class="card-body">
                    <h5 class="card-title">CBT - Food 4</h5>
                    <div>
                        <span class="badge-available-buy">cbt</span>
                        <span class="badge-available-buy">private</span>
                        <span class="badge-available">Available</span> <!-- Side-by-side badges -->
                    </div>
                    <p class="card-text">Price: Rs.100</p>
                    <a href="/buy/10-sets-package" class="btn buy-btn">BUY EXAM</a> <!-- Link Added -->
                </div>
            </div>

            <div class="card">
                <div class="exam-card-header">
                    <img src="/images/exam_logo.png" alt="EPS TOPIK" width="50" height="50">
                    <h6><strong>UBT-TEST</strong></h6>
                </div>
                <div class="card-body">
                    <h5 class="card-title">CBT - Mechinery 1</h5>
                    <div>
                        <span class="badge-available-buy">cbt</span>
                        <span class="badge-available-buy">private</span>
                        <span class="badge-available">Available</span> <!-- Side-by-side badges -->
                    </div>
                    <p class="card-text">Price: Rs.100</p>
                    <a href="/buy/10-sets-package" class="btn buy-btn">BUY EXAM</a> <!-- Link Added -->
                </div>
            </div>

            <div class="card">
                <div class="exam-card-header">
                    <img src="/images/exam_logo.png" alt="EPS TOPIK" width="50" height="50">
                    <h6><strong>UBT-TEST</strong></h6>
                </div>
                <div class="card-body">
                    <h5 class="card-title">CBT - Mechinery 2</h5>
                    <div>
                        <span class="badge-available-buy">cbt</span>
                        <span class="badge-available-buy">private</span>
                        <span class="badge-available">Available</span> <!-- Side-by-side badges -->
                    </div>
                    <p class="card-text">Price: Rs.100</p>
                    <a href="/buy/10-sets-package" class="btn buy-btn">BUY EXAM</a> <!-- Link Added -->
                </div>
            </div>

            <div class="card">
                <div class="exam-card-header">
                    <img src="/images/exam_logo.png" alt="EPS TOPIK" width="50" height="50">
                    <h6><strong>UBT-TEST</strong></h6>
                </div>
                <div class="card-body">
                    <h5 class="card-title">CBT - Mechinery 3</h5>
                    <div>
                        <span class="badge-available-buy">cbt</span>
                        <span class="badge-available-buy">private</span>
                        <span class="badge-available">Available</span> <!-- Side-by-side badges -->
                    </div>
                    <p class="card-text">Price: Rs.100</p>
                    <a href="/buy/10-sets-package" class="btn buy-btn">BUY EXAM</a> <!-- Link Added -->
                </div>
            </div>

            <div class="card">
                <div class="exam-card-header">
                    <img src="/images/exam_logo.png" alt="EPS TOPIK" width="50" height="50">
                    <h6><strong>UBT-TEST</strong></h6>
                </div>
                <div class="card-body">
                    <h5 class="card-title">CBT - Mechinery 4</h5>
                    <div>
                        <span class="badge-available-buy">cbt</span>
                        <span class="badge-available-buy">private</span>
                        <span class="badge-available">Available</span> <!-- Side-by-side badges -->
                    </div>
                    <p class="card-text">Price: Rs.100</p>
                    <a href="/buy/10-sets-package" class="btn buy-btn">BUY EXAM</a> <!-- Link Added -->
                </div>
            </div>

            <div class="card">
                <div class="exam-card-header">
                    <img src="/images/exam_logo.png" alt="EPS TOPIK" width="50" height="50">
                    <h6><strong>UBT-TEST</strong></h6>
                </div>
                <div class="card-body">
                    <h5 class="card-title">CBT - rubber/plastic 1</h5>
                    <div>
                        <span class="badge-available-buy">cbt</span>
                        <span class="badge-available-buy">private</span>
                        <span class="badge-available">Available</span> <!-- Side-by-side badges -->
                    </div>
                    <p class="card-text">Price: Rs.100</p>
                    <a href="/buy/10-sets-package" class="btn buy-btn">BUY EXAM</a> <!-- Link Added -->
                </div>
            </div>

            <div class="card">
                <div class="exam-card-header">
                    <img src="/images/exam_logo.png" alt="EPS TOPIK" width="50" height="50">
                    <h6><strong>UBT-TEST</strong></h6>
                </div>
                <div class="card-body">
                    <h5 class="card-title">CBT - rubber/plastic 2</h5>
                    <div>
                        <span class="badge-available-buy">cbt</span>
                        <span class="badge-available-buy">private</span>
                        <span class="badge-available">Available</span> <!-- Side-by-side badges -->
                    </div>
                    <p class="card-text">Price: Rs.100</p>
                    <a href="/buy/10-sets-package" class="btn buy-btn">BUY EXAM</a> <!-- Link Added -->
                </div>
            </div>

            <div class="card">
                <div class="exam-card-header">
                    <img src="/images/exam_logo.png" alt="EPS TOPIK" width="50" height="50">
                    <h6><strong>UBT-TEST</strong></h6>
                </div>
                <div class="card-body">
                    <h5 class="card-title">CBT - rubber/plastic 3</h5>
                    <div>
                        <span class="badge-available-buy">cbt</span>
                        <span class="badge-available-buy">private</span>
                        <span class="badge-available">Available</span> <!-- Side-by-side badges -->
                    </div>
                    <p class="card-text">Price: Rs.100</p>
                    <a href="/buy/10-sets-package" class="btn buy-btn">BUY EXAM</a> <!-- Link Added -->
                </div>
            </div>

            <div class="card">
                <div class="exam-card-header">
                    <img src="/images/exam_logo.png" alt="EPS TOPIK" width="50" height="50">
                    <h6><strong>UBT-TEST</strong></h6>
                </div>
                <div class="card-body">
                    <h5 class="card-title">CBT - rubber/plastic 4</h5>
                    <div>
                        <span class="badge-available-buy">cbt</span>
                        <span class="badge-available-buy">private</span>
                        <span class="badge-available">Available</span> <!-- Side-by-side badges -->
                    </div>
                    <p class="card-text">Price: Rs.100</p>
                    <a href="/buy/10-sets-package" class="btn buy-btn">BUY EXAM</a> <!-- Link Added -->
                </div>
            </div>

            <div class="card">
                <div class="exam-card-header">
                    <img src="/images/exam_logo.png" alt="EPS TOPIK" width="50" height="50">
                    <h6><strong>UBT-TEST</strong></h6>
                </div>
                <div class="card-body">
                    <h5 class="card-title">CBT - Metal 1</h5>
                    <div>
                        <span class="badge-available-buy">cbt</span>
                        <span class="badge-available-buy">private</span>
                        <span class="badge-available">Available</span> <!-- Side-by-side badges -->
                    </div>
                    <p class="card-text">Price: Rs.100</p>
                    <a href="/buy/10-sets-package" class="btn buy-btn">BUY EXAM</a> <!-- Link Added -->
                </div>
            </div>

            <div class="card">
                <div class="exam-card-header">
                    <img src="/images/exam_logo.png" alt="EPS TOPIK" width="50" height="50">
                    <h6><strong>UBT-TEST</strong></h6>
                </div>
                <div class="card-body">
                    <h5 class="card-title">CBT - Metal 2</h5>
                    <div>
                        <span class="badge-available-buy">cbt</span>
                        <span class="badge-available-buy">private</span>
                        <span class="badge-available">Available</span> <!-- Side-by-side badges -->
                    </div>
                    <p class="card-text">Price: Rs.100</p>
                    <a href="/buy/10-sets-package" class="btn buy-btn">BUY EXAM</a> <!-- Link Added -->
                </div>
            </div>

            <div class="card">
                <div class="exam-card-header">
                    <img src="/images/exam_logo.png" alt="EPS TOPIK" width="50" height="50">
                    <h6><strong>UBT-TEST</strong></h6>
                </div>
                <div class="card-body">
                    <h5 class="card-title">CBT - Metal 3</h5>
                    <div>
                        <span class="badge-available-buy">cbt</span>
                        <span class="badge-available-buy">private</span>
                        <span class="badge-available">Available</span> <!-- Side-by-side badges -->
                    </div>
                    <p class="card-text">Price: Rs.100</p>
                    <a href="/buy/10-sets-package" class="btn buy-btn">BUY EXAM</a> <!-- Link Added -->
                </div>
            </div>

            <div class="card">
                <div class="exam-card-header">
                    <img src="/images/exam_logo.png" alt="EPS TOPIK" width="50" height="50">
                    <h6><strong>UBT-TEST</strong></h6>
                </div>
                <div class="card-body">
                    <h5 class="card-title">CBT - Metal 4</h5>
                    <div>
                        <span class="badge-available-buy">cbt</span>
                        <span class="badge-available-buy">private</span>
                        <span class="badge-available">Available</span> <!-- Side-by-side badges -->
                    </div>
                    <p class="card-text">Price: Rs.100</p>
                    <a href="/buy/10-sets-package" class="btn buy-btn">BUY EXAM</a> <!-- Link Added -->
                </div>
            </div>
            
        </div>
    </div>
    
</div>


    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>