@extends('layouts.doctor')

@section('title', 'Doctor Dashboard')

@section('content')

<div class="container mt-4">
    <div class="row">
        <!-- Add Available Date -->
        <div class="col-md-6">
            <div class="card shadow-lg p-4">
                <h4 class="mb-3">Set Availability</h4>
                <form action="{{ route('doctor.addAvailability') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="available_date" class="form-label">Available Date</label>
                        <input type="date" class="form-control" min="{{ date('Y-m-d') }}" name="available_date" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Add Availability</button>
                </form>
            </div>
        </div>

        <!-- List Available Dates -->
        <div class="col-md-6">
            <div class="card shadow-lg p-4">
                <h4 class="mb-3">Available Dates</h4>
                <ul class="list-group">
                    {{-- {{dd($availabilities)}} --}}
                    @foreach($availabilities as $availability)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>{{ $availability->available_date }}</strong>
                            
                            <form action="{{ route('doctor.deleteAvailability', $availability->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection
