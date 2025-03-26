@extends('layouts.doctor')

@section('title', 'Patient Profile')

@section('content')
<div class="container mt-4">
    <h3 class="text-center mb-4">Patient Profile</h3>

    <div class="row">
        <!-- Left Column: Patient Details -->
        <div class="col-md-6">
            <!-- Patient Information Card -->
            <div class="card shadow-lg p-4 mb-5 bg-white rounded">
                <div class="card-body">
                    <h5 class="card-title text-center">Name: {{ $patientDetails->first_name }} {{ $patientDetails->last_name }}</h5>
                    <hr>
                    <p><strong>Patient ID:</strong> {{ $patientDetails->id }}</p>
                    @if ($patientDetails->patient)
                    <p><strong>Birthday:</strong> {{ $patientDetails->patient->DOB }}</p>
                    <p><strong>Blood Group:</strong> {{ $patientDetails->patient->blood_group }}</p>
                    <p><strong>Phone:</strong> {{ $patientDetails->patient->phone }}</p>
                @else
                    <p class="text-danger"><strong>Profile not updated</strong></p>
                @endif
                </div>
            </div>
        </div>

        <!-- Right Column: Add Medical Note Form -->
        <div class="col-md-6">
            <div>
                <h4 class="text-center mb-4">Add Medical Note</h4>
                <form action="{{ route('doctor.addMedical') }}" method="POST" class="form-group">
                    @csrf
                    <input type="hidden" name="patient_id" value="{{ $patientDetails->id }}">
                    <input type="hidden" name="doctor_id" value="{{ Auth::id() }}">

                    <div class="mb-3">
                        <label for="diagnosis" class="form-label">Diagnosis</label>
                        <input type="text" name="diagnosis" id="diagnosis" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="treatment" class="form-label">Treatment</label>
                        <input type="text" name="treatment" id="treatment" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Add Medical Note</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Full-width Medical History Section -->
    <div class="mt-5">
        <h4 class="text-center mb-4">Medical History</h4>
        @if ($medicalHistory->isEmpty())
        <p class="text-danger"><strong>No patient history available</strong></p>
    @else
        @foreach ($medicalHistory as $history)
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <p><strong>Doctor:</strong> {{$history->doctor->first_name}} {{$history->doctor->last_name}}</p>
                    <p><strong>Diagnosis:</strong> {{$history->diagnosis}}</p>
                    <p><strong>Treatment:</strong> {{$history->treatment}}</p>
                    <p><strong>Date:</strong> {{$history->created_at->format('Y-m-d')}}</p>
                </div>
            </div>
        @endforeach
    @endif
    
    </div>
</div>
@endsection
