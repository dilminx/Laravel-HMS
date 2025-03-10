@extends('layouts.patient')
@section('content')
    <div class="container mt-4">
        <div class="row">
            <!-- Doctor Info Section -->
            <div class="col-md-6">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h2>Dr. {{ $doctor->user->first_name }} {{ $doctor->user->last_name }}</h2>
                    </div>
                    <div class="card-body">
                        <p><strong>Specialization:</strong> {{ $doctor->specialization }}</p>
                        <p><strong>Work Hospital:</strong> {{ $doctor->work_hospital }}</p>
                        <p><strong>Phone:</strong> {{ $doctor->phone }}</p>
                        <p><strong>Category:</strong> {{ $doctor->category->name }}</p>
                        <p><strong>Channelling Charge:</strong> Rs. {{ number_format($doctor->category->price, 2) }}</p>

                        <h4>Available Dates</h4>
                        <form action="{{ route('patient.book.appointment') }}" method="POST">
                            @csrf
                            <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">

                            <select name="appointment_date" class="form-control" required>
                                <option value="">Select Available Date</option>
                                @foreach ($doctor->availability as $slot)
                                    @if ($slot->hasAvailableSlots())
                                        <option value="{{ $slot->available_date }}">{{ $slot->available_date }}</option>
                                    @endif
                                @endforeach
                            </select>

                            <button type="submit" class="btn btn-success mt-3">Book Appointment</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Feedback Section -->
            <div class="col-md-6">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-info text-white">
                        <h4>Leave Feedback</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('patient.submit.feedback') }}" method="POST">
                            @csrf
                            <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">
                            <div class="form-group">
                                <label for="message">Comments:</label>
                                <textarea name="message" class="form-control" rows="4" placeholder="Write your feedback here..." required></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary mt-3">Submit Feedback</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Display User Feedback -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-secondary text-white">
                <h4>User Feedback</h4>
            </div>
            <div class="card-body">
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
@endsection
