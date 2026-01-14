@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center my-4">
            <div>
                <h3 class="fw-bold text-dark">Transaction History</h3>
                <p class="text-muted small mb-0">Monitor all incoming payments from form submissions.</p>
            </div>
            <div>
                <button class="btn btn-outline-primary btn-sm"><i class="bi bi-download me-1"></i> Export Report</button>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3">Transaction ID</th>
                                <th>User</th>
                                <th>Form</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $txn)
                                <tr>
                                    <td class="ps-4">
                                        <span class="font-monospace small text-muted">
                                            {{ $txn->transaction_id }}
                                        </span>
                                    </td>

                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-primary bg-opacity-10 text-primary rounded-circle me-2 d-flex align-items-center justify-content-center"
                                                style="width:35px; height:35px;">
                                                {{ substr($txn->user->name ?? 'G', 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark" style="font-size: 0.9rem;">
                                                    {{ $txn->user->name ?? 'Guest' }}
                                                </div>
                                                <div class="text-muted small" style="font-size: 0.75rem;">
                                                    {{ $txn->user->email ?? '' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td>{{ $txn->form->name ?? 'Deleted Form' }}</td>

                                    <td class="fw-bold text-dark">
                                        ${{ number_format($txn->amount, 2) }} <span
                                            class="text-muted small text-uppercase">{{ $txn->currency }}</span>
                                    </td>

                                    <td>
                                        @if($txn->status === 'succeeded')
                                            <span
                                                class="badge bg-success bg-opacity-10 text-success border border-success px-3">Paid</span>
                                        @elseif($txn->status === 'pending')
                                            <span
                                                class="badge bg-warning bg-opacity-10 text-warning border border-warning px-3">Pending</span>
                                        @else
                                            <span
                                                class="badge bg-danger bg-opacity-10 text-danger border border-danger px-3">Failed</span>
                                        @endif
                                    </td>

                                    <td class="text-muted small">
                                        {{ $txn->created_at->format('M d, Y') }}<br>
                                        {{ $txn->created_at->format('h:i A') }}
                                    </td>

                                    <td class="text-end pe-4">
                                        <a href="https://dashboard.stripe.com/test/payments/{{ $txn->transaction_id }}"
                                            target="_blank" class="btn btn-sm btn-light border text-primary"
                                            title="View on Stripe">
                                            <i class="bi bi-box-arrow-up-right"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="bi bi-credit-card fs-1 d-block mb-3 opacity-50"></i>
                                            No transactions found yet.
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($transactions->hasPages())
                    <div class="p-3 border-top">
                        {{ $transactions->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection