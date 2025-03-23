@extends('layouts.doctor')

@section('title', 'My Confirmed Appointments')

@section('content')
<div class="container mt-4">
    <h3 class="text-center mb-4">Confirmed Appointments</h3>

    @if ($appointmentsByDate->isEmpty())
        <p class="text-center text-muted">No confirmed appointments available.</p>
    @else
        @foreach ($appointmentsByDate as $date => $appointments)
            <div class="mb-4 border p-3 rounded shadow-sm">
                <h5 class="text-primary">{{ \Carbon\Carbon::parse($date)->format('Y/m/d') }}</h5>
                <ul class="list-group">
                    @foreach ($appointments as $index => $appointment)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $index + 1 }} - {{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}
                            <span class="badge badge-info">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('H:i') }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    @endif
</div>

@endsection
