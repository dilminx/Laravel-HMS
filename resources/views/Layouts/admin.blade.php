<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}">

    <!-- SweetAlert2 -->
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
    <!-- jQuery & Bootstrap JS -->
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    
    <!-- Toastr JS -->
    <script src="{{ asset('js/toastr.min.js') }}"></script>


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
        .sidebar a, .logout-btn {
            padding: 12px 20px;
            text-decoration: none;
            font-size: 18px;
            color: white;
            display: block;
            border-radius: 5px;
            border: none;
            background: none;
            text-align: left;
            width: 100%;
        }
        .sidebar a:hover, .logout-btn:hover {
            background-color: #495057;
        }
        .content {
            margin-left: 260px;
            padding: 20px;
        }
        .navbar {
            background-color: #343a40;
            color: white;
            padding: 10px 20px;
        }
        .logout-container {
            padding: 20px;
            text-align: center;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="text-white text-center">Admin Panel</h4>
        <a href="{{ route('admin.dashboard') }}">🏠 Dashboard</a>
        <a href="{{ route('admin.users') }}">👥 Manage Users</a>
        <a href="{{route('admin.appointments')}}">📅 Appointments</a>
        <a href="#">💳 Payments</a>
        <a href="#">📊 Reports</a>

        <!-- Logout Button -->
        <form id="logoutForm" action="{{ route('logout') }}" method="GET">
            @csrf
            <button type="button" class="logout-btn" id="logoutBtn">🚪 Logout</button>
        </form>
    </div>

    <!-- Main Content -->
    <div class="content">
        

        <div class="container mt-4">
            <h2>@yield('title')</h2>
            <hr>
            @yield('content')
        </div>
    </div>

    
    <script>
        @if(session('success'))
            toastr.success("{{ session('success') }}");
        @endif

        @if(session('error'))
            toastr.error("{{ session('error') }}");
        @endif


    
        document.getElementById('logoutBtn').addEventListener('click', function (e) {
            e.preventDefault();
        
            Swal.fire({
                title: "Are you sure?",
                text: "You will be logged out!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, Logout!"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logoutForm').submit();
                }
            });
        });
    </script>

</body>
</html>
