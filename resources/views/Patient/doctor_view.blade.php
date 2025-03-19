@extends('layouts.patient')
@section('title','Doctor Details & Feedback')
@section('content')

<div class="container mt-5">
    <div class="container">
        <!-- Doctor Details -->
        <div class="col-md-8">
            <div class="card shadow-lg mb-4 border-0">
                <div class="card-header bg-primary text-white text-center">
                    <h3 class="mb-0">Dr. {{ $doctorDetails->first_name }} {{ $doctorDetails->last_name }}</h3>
                </div>
                <div class="card-body">
                    <p><strong>Specialization:</strong> {{ $doctorDetails2->specialization }}</p>
                    <p><strong>Work Hospital:</strong> {{ $doctorDetails2->work_hospital }}</p>
                    <p><strong>Phone:</strong> {{ $doctorDetails2->phone }}</p>

                    @if($doctorDetails2->category)
                        <p><strong>Category:</strong> {{ $doctorDetails2->category->name }}</p>
                        <p><strong>Channelling Charge:</strong> 
                            <span class="text-success fw-bold">Rs. {{ number_format($doctorDetails2->category->price, 2) }}</span>
                        </p>
                    @else
                        <p class="text-danger">No category assigned</p>
                    @endif

                    <h5 class="mt-4">Available Dates</h5>
                    <form id="appointment-form" action="{{ route('patient.book.appointment') }}" method="POST">
                        @csrf
                        <input type="hidden" name="doctor_id" value="{{ $doctorDetails->id }}">
                        <input type="hidden" name="doctor_category" value="{{  $doctorDetails2->category->name }}">
                        <input type="hidden" name="doctor_price" value="{{ $doctorDetails2->category->price }}">

                        <select name="appointment_date" class="form-control mt-2" required>
                            <option value="">Select Available Date</option>
                            @forelse ($availabilities as $slot)
                                @if ($slot->hasAvailableSlots() && $slot->available_date >= date('Y-m-d'))
                                    <option value="{{ $slot->available_date }}">{{ $slot->available_date }}</option>
                                @endif
                            @empty
                                <option value="">No available dates</option>
                            @endforelse
                        </select>

                        <div class="form-group mt-3">
                            <label for="payment_method">Payment Method</label>
                            <select name="payment_method" id="payment_method" class="form-control" required>
                                <option value="">Choose Payment Method</option>
                                <option value="cash">Cash</option>
                                <option value="card">Card</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success mt-3 w-100">Book Appointment</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Feedback Section -->
    <div class="row mt-5">
        <!-- Feedback Form -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-info text-white">
                    <h4>Leave Feedback</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('patient.submit.feedback') }}" method="POST">
                        @csrf
                        <input type="hidden" name="doctor_id" value="{{ $doctorDetails->id }}">
                        <div class="form-group">
                            <label for="message">Comments:</label>
                            <textarea name="message" class="form-control" rows="4" placeholder="Write your feedback here..." required></textarea>
                        </div>
                    
                        <button type="submit" class="btn btn-primary mt-3 w-100">Submit Feedback</button>
                    </form>
                    
                </div>
            </div>
        </div>

        <!-- Feedback Display -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-dark text-white">
                    <h4>User Feedback</h4>
                </div>
                <div class="card-body">
                    @if($feedbacks->isEmpty())
                        <p class="text-muted">No feedback available.</p>
                    @else
                        <div class="row">
                            @foreach($feedbacks as $index => $feedback)
                                <div class="col-md-6">
                                    <div class="card mb-3 shadow-sm">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $feedback->patient->first_name ?? 'Unknown' }} {{ $feedback->patient->last_name ?? '' }}</h5>
                                            <h6 class="card-subtitle mb-2 text-muted">{{ $feedback->patient->email ?? 'Unknown' }}</h6>
                                            <p class="card-text">{{ $feedback->message }}</p>
                                            <small class="text-muted">{{ $feedback->created_at->format('Y-m-d') }}</small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert2 for Confirmation -->
<script>
    document.getElementById("appointment-form").addEventListener("submit", function(event) {
        event.preventDefault();

        let paymentMethod = document.getElementById("payment_method").value;

        if (!paymentMethod) {
            Swal.fire("Error", "Please select a payment method!", "error");
            return;
        }

        Swal.fire({
            title: "Confirm Appointment",
            text: "Are you sure you want to book this appointment?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, Proceed",
            cancelButtonText: "Cancel"
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
            }
        });
    });
</script>

@endsection
