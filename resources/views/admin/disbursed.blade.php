@extends('admin.layouts.app')

@section('content')
<div class="card-custom p-4">
    <h5 class="mb-4 fw-bold">Transaction History (Disbursed)</h5>
    <div class="alert alert-info border-0 d-flex align-items-center">
        <i class="bi bi-info-circle-fill me-2"></i>
        <span>Total disbursed this month: <strong>$450,000</strong></span>
    </div>
    
    <table class="table table-bordered border-light">
        <thead class="table-light">
            <tr>
                <th>Transaction ID</th>
                <th>Recipient</th>
                <th>Bank Account</th>
                <th>Amount</th>
                <th>Date Processed</th>
                <th>Receipt</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>TXN_998877</td>
                <td>Sarah Connor</td>
                <td>**** 4545</td>
                <td class="text-success fw-bold">+$25,000</td>
                <td>Oct 20, 2025</td>
                <td><a href="#" class="text-decoration-none">View PDF</a></td>
            </tr>
        </tbody>
    </table>
</div>
@endsection