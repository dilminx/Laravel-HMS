@extends('layouts.patient')
@section('content')

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Doctor Name</th>
            <th>Specialization</th>
            <th>Work Hospital</th>
            <th>Phone</th>
            <th>Category</th>
            <th>Chanelling Charge</th>
            <th>Appointment</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($doctors as $doctor)
        <tr>
            <td>{{ $doctor->first_name }} {{ $doctor->last_name }}</td>
            <td>{{ $doctor->doctor->specialization ?? 'N/A' }}</td> 
            <td>{{ $doctor->doctor->work_hospital ?? 'N/A' }}</td> 
            <td>{{ $doctor->doctor->phone ?? 'N/A' }}</td> 
            <td>{{ $doctor->doctor->category->name ?? 'N/A' }}</td> 
            <td>{{ $doctor->doctor->category->price ?? 'N/A' }}</td> 
            <td>
                <button class="btn btn-primary">Appointment</button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
