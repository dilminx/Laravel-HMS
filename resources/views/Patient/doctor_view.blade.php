@extends('layouts.patient')
@section('content')
<div class="container mt-4">
    <div class="row">
        <!-- Left Section: Doctor Details & Feedback -->
        <div class="col-md-6">
            <!-- Doctor Info Section -->
            <div class="card shadow-lg mb-4">
                <div class="card-header bg-primary text-white">
                    <h3>Dr. {{ $doctor->user->first_name }} {{ $doctor->user->last_name }}</h3>
                </div>
                <div class="card-body">
                    <p><strong>Specialization:</strong> {{ $doctor->specialization }}</p>
                    <p><strong>Work Hospital:</strong> {{ $doctor->work_hospital }}</p>
                    <p><strong>Phone:</strong> {{ $doctor->phone }}</p>
                    <p><strong>Category:</strong> {{ $doctor->category->name }}</p>
                    <p><strong>Channelling Charge:</strong> Rs. {{ number_format($doctor->category->price, 2) }}</p>

                    <h5 class="mt-4">Available Dates</h5>
                    <form action="{{ route('patient.book.appointment') }}" method="POST">
                        @csrf
                        <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">

                        <select name="appointment_date" class="form-control mt-2" required>
                            <option value="">Select Available Date</option>
                            @foreach ($doctor->availability as $slot)
                                @if ($slot->hasAvailableSlots())
                                    <option value="{{ $slot->available_date }}">{{ $slot->available_date }}</option>
                                @endif
                            @endforeach
                        </select>

                        <button type="submit" class="btn btn-success mt-3 w-100">Book Appointment</button>
                    </form>
                </div>
            </div>

            <!-- Feedback Section -->
            <div class="card shadow-lg mb-4">
                <div class="card-header bg-info text-white">
                    <h4>Leave Feedback</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('patient.submit.feedback') }}" method="POST">
                        @csrf
                        <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">
                        <div class="form-group">
                            <label for="message">Comments:</label>
                            <textarea name="message" class="form-control mt-2" rows="4" placeholder="Write your feedback here..." required></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary mt-3 w-100">Submit Feedback</button>
                    </form>
                </div>
            </div>

            <!-- Display User Feedback -->
            <div class="card shadow-lg mb-4">
                <div class="card-header bg-secondary text-white">
                    <h4>User Feedback</h4>
                </div>
                <div class="card-body">
                    @if($feedbacks->isEmpty())
                        <p class="text-muted text-center">No feedback available.</p>
                    @else
                        <div class="list-group">
                            @foreach($feedbacks as $feedback)
                                <div class="card mb-3 shadow-sm">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $feedback->patient->first_name ?? 'Unknown' }} {{ $feedback->patient->last_name ?? '' }}</h5>
                                        <h6 class="card-subtitle mb-2 text-muted">{{ $feedback->patient->email ?? 'Unknown' }}</h6>
                                        <p class="card-text">{{ $feedback->message }}</p>
                                        <small class="text-muted">{{ $feedback->created_at->format('Y-m-d') }}</small>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Section: My Appointments -->
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-header bg-info text-white text-center">
                    <h4>My Appointments</h4>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        @forelse ($myappointments as $myappointment)
                            <div class="card mb-3 shadow-sm">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="mb-0">{{ $myappointment->appointment_date }}</h5>
                                        <small class="text-muted">{{ $myappointment->status }}</small>
                                    </div>
                                    <form action="{{ route('appointment.cancel', $myappointment->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Cancel</button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted text-center">No appointments booked.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
