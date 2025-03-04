<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registration</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
        .card {
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center bg-primary text-white">
                    <h3>Register</h3>
                </div>
                <div class="card-body">

                    <form id="registerForm" action="{{ route('register.submit') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">First Name</label>
                            <input type="text" name="firstName" class="form-control" value="{{ old('firstName') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Last Name</label>
                            <input type="text" name="lastName" class="form-control" value="{{ old('lastName') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Register</button>
                    </form>
                    <p>Alredy Have an Account? <a href="/login">login</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- jQuery (Required for Toastr) -->
<script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
<!-- Bootstrap JS -->
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<!-- Toastr JS -->
<script src="{{ asset('js/toastr.min.js') }}"></script>

<script>
    // Show success message
    @if (session('success'))
        toastr.success("{{ session('success') }}");
    @endif

    // Show validation errors using Toastr
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            toastr.error("{{ $error }}");
        @endforeach
    @endif
</script>

</body>
</html>
