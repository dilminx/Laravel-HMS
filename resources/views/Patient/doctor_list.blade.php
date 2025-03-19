@extends('layouts.patient')
@section('title','My Appointments & Appointments Doctors')
@section('content')
<div class="container">
    <!-- My Appointments -->
    <div class="col-md-6">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-info text-white text-center">
                <h4>My Appointments</h4>
            </div>
            <div class="card-body">
                <div class="list-group">
                    @foreach ($myappointments as $myappointment)
                    {{-- {{dd($myappointment->doctor)}} --}}
                    <div class="card mb-3 shadow-sm">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-0">{{ $myappointment->appointment_date }}</h5>
                                
                                <!-- Check if doctor exists before accessing properties -->
                                @if ($myappointment->doctor)
                                <h5 class="mb-0">{{ $myappointment->doctor->first_name }} {{ $myappointment->doctor->last_name }}</h5>
                                
                                @if ($myappointment->doctor->category)
                                    <h5 class="mb-0">{{ $myappointment->doctor->category->name }}</h5>
                                @endif
                            @endif
                            
                
                                <span class="badge bg-{{ $myappointment->status == 'confirmed' ? 'success' : 'warning' }}">
                                    {{ ucfirst($myappointment->status) }}
                                </span>
                            </div>
                            <form action="{{ route('appointment.cancel', $myappointment->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Cancel</button>
                            </form>
                        </div>
                    </div>
                @endforeach
                </div>
            </div>
        </div>
    </div>

    
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
@if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('success') }}'
        });
    </script>
@endif

@if (session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '{{ session('error') }}'
        });
    </script>
@endif

@endsection
