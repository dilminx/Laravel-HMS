@extends('layouts.patient')
@section('title', 'Medical History')

@section('content')
<div class="container bg-secondary text-white p-2">
    <h2>Medical History - {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h2>
</div>

<div class="container m-2 p-2">
    @if ($medicals->isEmpty())  
        <p>No medical history available.</p>
    @else
        <table id="medicalHistoryTable" class="table table-bordered table-striped">
            <thead class="table-info">
                <tr>
                    <th>Date</th>
                    <th>Diagnosis</th>
                    <th>Treatment</th>
                    <th>Doctor</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($medicals as $medical)
                <tr>
                    <td>{{ $medical->created_at->format('Y-m-d') }}</td>
                    <td>{{ $medical->diagnosis }}</td>
                    <td>{{ $medical->treatment }}</td>
                    <td>{{ $medical->doctor->first_name }} {{ $medical->doctor->last_name }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
