@extends('layouts.patient')
@section('title','Payment History')
@section('content')
<h4>payment details</h4>
<table class="table table-static">
    <thead class="table-info">
        <th>Doctor Name</th>
        <th>Paid Date</th>
        <th>Amount</th>
        <th>Status</th>
    </thead>
    @foreach ($payments as $payment)
    <tbody>
        <td>Dr.{{$payment->doctor->first_name}} {{$payment->doctor->last_name}}</td>
        <td>{{$payment->created_at->format('Y-m-d')}}</td> 
        <td>{{$payment->amount}}</td> 
        <td>{{$payment->status}}</td> 
                 
    </tbody>
    @endforeach
</table>
@endsection