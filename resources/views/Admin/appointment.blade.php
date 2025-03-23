@extends('layouts.admin')
@section('title','Appointments Details')

@section('content')
<div class="container mt-4">
    
    
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Patient Name</th>
                <th>Doctor Name</th>
                <th>Specialization</th>
                <th>Appointment Date</th>
                <th>Payment & Appointment Status</th>
                
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($appointmentDetails as $appointment)
                <tr>
                    <td>{{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}</td>
                    <td>{{ $appointment->doctor->first_name }} {{ $appointment->doctor->last_name }}</td>
                    <td>{{ $appointment->doctor->doctor->category->name }}</td>
                    <td>{{ $appointment->appointment_date }}</td>
                    <td>
                        <span class="badge bg-{{ $appointment->status == 'confirmed' ? 'success' : 'warning' }}">
                            {{ ucfirst($appointment->status) }}
                        </span>
                    </td>
                   
                    <td>
                        @if ($appointment->status == 'pending')
                            <form action="{{ route('admin.appointments.confirm', $appointment->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-success btn-sm">Confirm</button>
                            </form>
                    
                            <form action="{{ route('admin.appointments.cancel', $appointment->id) }}" method="POST" class="d-inline">
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
@endsection
