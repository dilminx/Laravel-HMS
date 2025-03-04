<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}">
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card mt-5">
                <div class="card-header text-center bg-primary text-white">
                    <h3>Login</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('login.submit') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>
                    <p>Not Have Register Yet? <a href="/register">Register Now</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
<!-- Bootstrap JS -->
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<!-- Toastr JS -->
<script src="{{ asset('js/toastr.min.js') }}"></script>

<script>
    @if (session('error'))
        toastr.error("{{ session('error') }}");
    @endif
    @if (session('success'))
        toastr.success("{{ session('success') }}");
    @endif
</script>

</body>
</html>
