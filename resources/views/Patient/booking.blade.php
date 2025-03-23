@extends('layouts.patient')
@section('title','Booking Doctors')
@section('content')
<div class="container">
    <div class="container mt-4">
        {{-- {{ dd($categories) }} --}}
        @foreach ($categories as $category)
            @if ($category->doctors->isEmpty())
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
                        {{-- {{dd($category->doctors )}} --}}
                        @foreach ($category->doctors as $doctor) 
                        {{-- {{dd($doctor)}} --}}
                            <tr>
                                @if ($doctor->user)
                                    <td>{{ $doctor->user->first_name }} {{ $doctor->user->last_name }}</td>
                                    <td><a href="{{ route('patient.doctor.view', $doctor->user->id) }}" class="btn btn-primary">View Profile</a></td>
                                @else
                                    <td colspan="2" class="text-danger">Doctor Profile Not Found</td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        @endforeach
    </div>
    

</div>

@endsection