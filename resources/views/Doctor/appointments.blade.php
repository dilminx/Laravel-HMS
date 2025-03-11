@extends('layouts.doctor')
@section('content')
<div class="container mt-4">
    <h2 class="bg-primary text-white p-3 text-center">My Appointments</h2>

    <div class="card shadow-lg">
        <div class="card-body">
            @if($appointments->isEmpty())
                <p class="text-muted text-center">No appointments available.</p>
            @else
                <table class="table table-bordered">
                    <thead class="bg-info text-white">
                        <tr>
                            <th>#</th>
                            <th>Patient Name</th>
                            <th>Appointment Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($appointments as $index => $appointment)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}</td>
                                <td>{{ $appointment->appointment_date }}</td>
                                <td>
                                    <span class="badge {{ $appointment->status == 'confirmed' ? 'bg-success' : 'bg-warning' }}">
                                        {{ ucfirst($appointment->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection
