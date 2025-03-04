@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="card p-3">
        <h3>Welcome {{$user->first_name}}</h3>
        <p>Email: {{ Auth::user()->email }}</p>
        <p>Manage users, appointments, and more from here.</p>
    </div>
@endsection
