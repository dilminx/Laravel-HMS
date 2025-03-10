@extends('layouts.patient')
@section('content')

<div class="container mt-4">
    @foreach ($categories as $category)
@if (empty($category->doctors))
    <h2>No Doctors</h2>
@else
    <h3>{{ $category->name }}</h3>
    <!-- Doctor Category Name -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Doctor's Name</th>
                <th scope="col">Profile</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($category->doctors as $doctor)
                <tr>
                    <td>{{ $doctor->user->first_name }} {{ $doctor->user->last_name }}</td>
                    <td><a href="{{ route('patient.doctor.view', $doctor->id) }}" class="btn btn-primary">View Profile</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
    @endforeach
</div>

@endsection
