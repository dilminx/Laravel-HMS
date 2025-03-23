<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Patient Dashboard</title>
 <!-- Bootstrap CSS -->
 <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
 
 <!-- SweetAlert2 -->
     <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
     
 <!-- Toastr CSS -->
 <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}">    <style>

     
     body {
         display: flex;
        }
        .sidebar {
            width: 250px;
            height: 100vh;
            background: #343a40;
            color: white;
            padding: 20px;
            position: fixed;
        }
        .sidebar a {
            color: white;
            display: block;
            padding: 10px;
            text-decoration: none;
        }
        .sidebar a:hover {
            background: #495057;
        }
        .content {
            margin-left: 270px;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h3>Patient Panel</h3>
        <a href="{{ route('patient.dashboard') }}">Dashboard</a>
        <a href="{{ route('patient.history') }}">Medical History</a>
        <a href="{{ route('patient.booking') }}">Booking Doctors</a>
        <a href="{{ route('patient.appointments') }}">Appointments</a>
        <a href="{{ route('patient.payments') }}">Payment Details</a>
        <a href="{{ route('logout') }}">Logout</a>
    </div>
    <div class="content">
        <div class="container">
            <h2>@yield('title')</h2>
            <hr>
            @yield('content')
        </div>
    </div>
    {{-- ====================================js========================== --}}
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
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
