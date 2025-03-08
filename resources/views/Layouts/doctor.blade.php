<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Dashboard</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            background-color: #343a40;
            padding-top: 20px;
        }
        .sidebar a {
            padding: 10px;
            text-decoration: none;
            font-size: 18px;
            color: white;
            display: block;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="text-white text-center">Doctor Panel</h4>
        <a href="{{ route('doctor.dashboard') }}">Dashboard</a>
        <a href="{{ route('doctor.available_dates') }}">Available Dates</a>
        <a href="{{ route('doctor.appointments') }}">Appointments</a>
        <a href="{{ route('doctor.patients_list') }}">Patients List</a>
        <a href="{{ route('doctor.payments') }}">Payments</a>
        <a href="{{ route('logout') }}">Logout</a>
    </div>

    <!-- Main Content -->
    <div class="content">
        <div class="container">
            <h2>@yield('title')</h2>
            <hr>
            @yield('content')
        </div>
    </div>

    <!-- jQuery & Bootstrap JS -->
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    
    <!-- Toastr JS -->
    <script src="{{ asset('js/toastr.min.js') }}"></script>

    <script>
        @if(session('success'))
            toastr.success("{{ session('success') }}");
        @endif

        @if(session('error'))
            toastr.error("{{ session('error') }}");
        @endif
    </script>

</body>
</html>