@extends('layouts.admin')

@section('title', 'User Management')

@section('content')
<div class="container mt-4">
    <div class="card shadow-lg p-4">
        <h2 class="mb-4 text-center">Add New User</h2>
        
        <form action="{{ route('admin.addUser') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="first_name" class="form-label">First Name</label>
                    <input type="text" name="first_name" id="first_name" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input type="text" name="last_name" id="last_name" class="form-control" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select name="role" id="role" class="form-select" required>
                    <option value="doctor">Doctor</option>
                    <option value="patient">Patient</option>
                    <option value="lab_assistant">Lab Assistant</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary w-100">Add User</button>
        </form>
    </div>

    <div class="card mt-5 shadow-lg">
        <div class="card-header text-center">
            <h3>User List</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Role</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                            <td>{{ ucfirst($user->role) }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge {{ $user->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                                    {{ ucfirst($user->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.toggleStatus', $user->id) }}" class="btn btn-sm {{ $user->status == 'active' ? 'btn-danger' : 'btn-success' }}">
                                    {{ $user->status == 'active' ? 'Deactivate' : 'Activate' }}
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>  
        </div>
    </div>
</div>

@endsection
