@extends('layouts.patient')
@section('title','My Appointments & Appointments Doctors')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12"> <!-- Reduced width -->
            <table class="table table-bordered table-sm text-center"> <!-- Compact table -->
                <thead class="table-info">
                    <tr>
                        <th>Appointment Date</th>
                        <th>Doctor</th>
                        <th>Specialization</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($myappointments as $myappointment)
                    <tr>
                        <td>{{ $myappointment->appointment_date }}</td>
                        <td>Dr. {{ $myappointment->doctor->first_name }} {{ $myappointment->doctor->last_name }}</td>
                        <td>{{ $myappointment->doctor->doctor->category->name ?? 'N/A' }}</td>
                        <td>
                            <span class="badge bg-{{ $myappointment->status == 'confirmed' ? 'success' : 'warning' }}">
                                {{ ucfirst($myappointment->status) }}
                            </span>
                        </td>
                        <td>
                            @if ($myappointment->status == 'pending')
                            <form action="{{ route('appointment.cancel', $myappointment->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Cancel</button>
                            </form>
                            @else
                            <button class="btn btn-secondary btn-sm" disabled>Processed</button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
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
