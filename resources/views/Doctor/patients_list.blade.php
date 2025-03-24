@extends('layouts.doctor')
@section('title', 'Patients List')
@section('content')
    {{-- {{dd($patients)}}     --}}
    <table class="table table-static">
        <thead class="table-secondary">
            <th>patiant ID</th>
            <th>patiant Name</th>
            <th>Email</th>
            <th>Action</th>
        </thead>
        @foreach ($patients as $patient)
        {{-- {{dd($patient)}} --}}
            <tbody>
                <td>{{$patient->id}}</td>
                <td>{{$patient->first_name}} {{$patient->last_name}}</td>
                <td>{{$patient->email}}</td>
                <td ><a href="{{route('doctor.patientProfile',$patient->id)}}" class="btn btn-primary">view Profile</a></td>

            </tbody>
        @endforeach
    </table>
@endsection
