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

        .active {
            background-color: skyblue;
            color: white;
        }

        .profile-section {
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f8f9fa;
            max-width: 500px;
            position: relative;
        }

        .profile-section h3 {
            color: #007bff;
            text-align: center;
        }

        .profile-section .form-group {
            margin-bottom: 15px;
        }

        .hover-menu {
            display: none;
            position: absolute;
            background-color: white;
            border: 1px solid #ddd;
            z-index: 1000;
            right: 0;
            width: 150px;
        }

        .user-icon:hover .hover-menu {
            display: block;
        }

        .hover-menu a {
            color: black;
            padding: 10px;
            text-decoration: none;
            display: block;
        }

        .hover-menu a:hover {
            background-color: #007bff;
            color: white;
        }

        .user-info {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .user-info .user-name {
            display: flex;
            align-items: center;
        }

        .user-info .user-name span {
            margin-right: 8px;
        }

        .user-info .user-name .fas {
            font-size: 30px;
        }

        .user-info span.role {
            margin-left: 0px;
        }

        .result-card {
            padding: 15px;
        }

        /* Custom changes */
        .card-header h4 {
            color: #448EE4;
        }

        .card-body {
            padding: 10px;
        }

        .table th,
        .table td {
            text-align: center;
            vertical-align: middle;
        }

        .d-flex {
            justify-content: space-between;
        }

        /* Date input styles */
        .date-filter {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
            margin-left: 50%;
        }

        .date-filter label {
            margin-right: 5px;
        }

        .date-filter input[type="date"] {
            border-radius: 4px;
            padding: 3px;
            margin: 0 2px;
        }

        .page-control {
            display: flex;
            justify-content: space-between;
            align-items: center;
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
        <h3>EPS-TOPIK UBT TRAIL EXAM</h3>
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
                <a href="#">Logout</a>
            </div>
        </div>
    </div>

    <!-- List of Results -->
    <div class="card mt-4">
        <div class="card-header">
            <h4>List of Results</h4>
        </div>
        <div class="card-body">
            <!-- Date Range Filter -->
            <div class="date-filter">
                <label for="from-date">Showing Results From:</label>
                <input type="date" id="from-date" name="from-date" value="2024-09-25">
                <label for="to-date">to</label>
                <input type="date" id="to-date" name="to-date" value="2024-10-05">
            </div>

            <!-- Table -->
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Score</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Color Vision Test</td>
                        <td>0</td>
                        <td>2024-10-01</td>
                        <td><i class="fas fa-eye" style="color: #007bff;"></i></td>
                    </tr>
                </tbody>
            </table>

            <!-- Pagination Controls -->
            <div class="page-control">
                <div>Rows per page: 
                    <select class="form-control d-inline-block" style="width: auto;">
                        <option value="20">20</option>
                        <option value="10">10</option>
                        <option value="50">50</option>
                    </select>
                </div>
                <div>1–1 of 1</div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>