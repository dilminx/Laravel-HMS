@extends('layouts.doctor')

@section('title', 'Doctor Dashboard')

@section('content')

<div class="container mt-4">
    <div class="row">
        <!-- Doctor Update Form -->
        <div class="col-md-6">
            <div class="card shadow-lg p-4">
                <h4 class="mb-3">Update Doctor Info</h4>
                <form action="{{ route('doctor.update') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" class="form-control" name="first_name" value="{{ Auth::user()->first_name }}">
                    </div>
                    <div class="mb-3">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" class="form-control" name="last_name" value="{{ Auth::user()->last_name }}">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" value="{{ Auth::user()->email }}">
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">TP Number</label>
                        <input type="text" class="form-control" name="phone" value="{{ $doctor->phone ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label for="specialization" class="form-label">Specialization</label>
                        <input type="text" class="form-control" name="specialization" value="{{ $doctor->specialization ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label for="work_hospital" class="form-label">Work Hospital</label>
                        <input type="text" class="form-control" name="work_hospital" value="{{ $doctor->work_hospital ?? '' }}">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Update Doctor</button>
                </form>
            </div>
        </div>

        <!-- User Feedback Section -->
        <div class="col-md-6">
            <div class="card shadow-lg p-4">
                <h4 class="mb-3">User Feedback</h4>
                @if($feedbacks->isEmpty())
                    <p class="text-muted">No feedback available.</p>
                @else
                    <div class="list-group">
                        @foreach($feedbacks as $feedback)
                        <div class="card mb-3 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">{{ $feedback->patient->first_name ?? 'Unknown' }} {{ $feedback->patient->last_name ?? '' }}</h5>
                                <h6 class="card-subtitle mb-2 text-muted">{{ $feedback->patient->email ?? 'Unknown' }}</h6>
                                <p class="card-text">{{ $feedback->message }}</p>
                                <i class="card-text">{{ $feedback->created_at->format('Y-m-d') }}</i>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
