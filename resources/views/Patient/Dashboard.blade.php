@extends('layouts.patient')
@section('title', 'Patient Dashboard')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="container p-4">
            <div class="card shadow-lg" style="min-height: 90vh;">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0 text-center">Update Patient Details</h4>
                </div>

                <div class="container p-4 text-center">
                    <!-- Profile Photo Display -->
                    @if(Auth::user()->profile_photo)
                        <div class="d-flex justify-content-center">
                            <img src="{{ asset('storage/profile_photos/' . Auth::user()->profile_photo) }}" 
                                alt="Profile Photo" 
                                class="img-thumbnail rounded-circle d-flex justify-content-center shadow"
                                style="width: 170px; height: 180px; object-fit: cover;">
                        </div>
                    @else
                        <p class="text-muted">No profile photo uploaded.</p>
                    @endif
                </div>

                <div class="container p-4">
                    <form action="{{ route('patient.update') }}" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="first_name" class="form-label">First Name</label>
                                    <input type="text" name="first_name" class="form-control" value="{{ old('first_name', Auth::user()->first_name) }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="last_name" class="form-label">Last Name</label>
                                    <input type="text" name="last_name" class="form-control" value="{{ old('last_name', Auth::user()->last_name) }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" value="{{ old('email', Auth::user()->email) }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="profile_photo" class="form-label">Profile Photo</label>
                                    <input type="file" name="profile_photo" class="form-control" accept="image/*">
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="DOB" class="form-label">Birth Date</label>
                                    <input type="date" name="DOB" class="form-control" value="{{ old('DOB', $patient->DOB ?? '') }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="blood_group" class="form-label">Blood Group</label>
                                    <input type="text" name="blood_group" class="form-control" value="{{ old('blood_group', $patient->blood_group ?? '') }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $patient->phone ?? '') }}" required>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="row mt-4">
                            <div class="text-center">
                                <button class="btn btn-primary" type="submit">Update Profile</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>  
        </div>
    </div>
</div>
@endsection
