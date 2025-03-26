@extends('layouts.doctor')

@section('title', 'Payments')

@section('content')
<div class="container mt-4">
    <div class="card shadow-lg p-4">
        <h4 class="mb-3">Payment Details</h4>

        @if($paymentDetails->isEmpty())
            <p class="text-muted">No payments found.</p>
        @else
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Patient Name</th>
                        <th>Patient Email</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($paymentDetails as $index => $payment)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $payment->patient->first_name }} {{ $payment->patient->last_name }}</td>
                        <td>{{ $payment->patient->email }} </td>
                        <td>Rs. {{ number_format($payment->amount, 2) }}</td>
                        <td>
                            @if($payment->status == 'completed')
                                <span class="badge bg-success">Completed</span>
                            @elseif($payment->status == 'pending')
                                <span class="badge bg-warning">Pending</span>
                            @else
                                <span class="badge bg-danger">Cancelled</span>
                            @endif
                        </td>
                        <td>{{ $payment->created_at->format('Y-m-d') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection
