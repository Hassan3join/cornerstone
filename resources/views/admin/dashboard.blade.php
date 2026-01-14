@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center my-4 gap-3">
        <div>
            <h3 class="fw-bold text-dark mb-0">Dashboard Overview</h3>
            <p class="text-muted small mb-0">
                Showing data from <span class="fw-bold text-dark">{{ $date_range['start']->format('M d, Y') }}</span> to <span class="fw-bold text-dark">{{ $date_range['end']->format('M d, Y') }}</span>
            </p>
        </div>

        <form action="{{ route('admin.dashboard') }}" method="GET" class="d-flex align-items-center gap-2 bg-white p-2 rounded-3 shadow-sm border">
            <div class="input-group input-group-sm">
                <span class="input-group-text bg-transparent border-0 text-muted"><i class="bi bi-calendar3"></i></span>
                <input type="date" name="start_date" class="form-control border-0 fw-bold" 
                       value="{{ $date_range['start']->format('Y-m-d') }}" required>
            </div>
            <span class="text-muted fw-bold">-</span>
            <div class="input-group input-group-sm">
                <input type="date" name="end_date" class="form-control border-0 fw-bold" 
                       value="{{ $date_range['end']->format('Y-m-d') }}" required>
            </div>
            <button type="submit" class="btn btn-primary btn-sm px-3 fw-bold rounded-pill">Filter</button>
            
            <a href="{{ route('admin.dashboard') }}" class="btn btn-light btn-sm rounded-circle" title="Reset to Month">
                <i class="bi bi-arrow-counterclockwise"></i>
            </a>
        </form>
    </div>

    <div class="row g-4 mb-4">
        
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 rounded-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="text-muted small fw-bold text-uppercase">Total Applications</div>
                        <div class="icon-shape bg-primary bg-opacity-10 text-primary rounded-3 p-2">
                            <i class="bi bi-file-earmark-text fs-5"></i>
                        </div>
                    </div>
                    <h2 class="fw-bold mb-2">{{ number_format($total_apps['count']) }}</h2>
                    <div class="small {{ $total_apps['growth'] >= 0 ? 'text-success' : 'text-danger' }}">
                        <i class="bi bi-arrow-{{ $total_apps['growth'] >= 0 ? 'up' : 'down' }}"></i> 
                        {{ abs($total_apps['growth']) }}% <span class="text-muted">vs previous period</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 rounded-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="text-muted small fw-bold text-uppercase">Pending Approval</div>
                        <div class="icon-shape bg-warning bg-opacity-10 text-warning rounded-3 p-2">
                            <i class="bi bi-hourglass-split fs-5"></i>
                        </div>
                    </div>
                    <h2 class="fw-bold mb-2">{{ number_format($pending_count) }}</h2>
                    <div class="small text-warning">
                        <i class="bi bi-circle-fill" style="font-size: 8px;"></i> Requires attention
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 rounded-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="text-muted small fw-bold text-uppercase">Fees Collected</div>
                        <div class="icon-shape bg-success bg-opacity-10 text-success rounded-3 p-2">
                            <i class="bi bi-cash-stack fs-5"></i>
                        </div>
                    </div>
                    <h2 class="fw-bold mb-2">${{ number_format($revenue['amount'], 2) }}</h2>
                    <div class="small {{ $revenue['growth'] >= 0 ? 'text-success' : 'text-danger' }}">
                        <i class="bi bi-arrow-{{ $revenue['growth'] >= 0 ? 'up' : 'down' }}"></i> 
                        {{ abs($revenue['growth']) }}% <span class="text-muted">vs previous period</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 rounded-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="text-muted small fw-bold text-uppercase">Rejected</div>
                        <div class="icon-shape bg-danger bg-opacity-10 text-danger rounded-3 p-2">
                            <i class="bi bi-x-circle fs-5"></i>
                        </div>
                    </div>
                    <h2 class="fw-bold mb-2">{{ number_format($rejected_count) }}</h2>
                    <div class="small text-danger">
                        Strict Eligibility
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 mb-5">
        <div class="card-header bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0">Recent Loan Requests</h5>
            <a href="{{ route('admin.applicants') }}" class="btn btn-light btn-sm rounded-pill px-3">View All</a>
        </div>
        <div class="table-responsive">
            <table class="table align-middle table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 text-secondary small text-uppercase fw-bold">Applicant</th>
                        <th class="text-secondary small text-uppercase fw-bold">Form / Type</th>
                        <th class="text-secondary small text-uppercase fw-bold">Status</th>
                        <th class="text-secondary small text-uppercase fw-bold">Date</th>
                        <th class="text-end pe-4 text-secondary small text-uppercase fw-bold">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recent_requests as $sub)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center me-3 fw-bold" 
                                     style="width: 40px; height: 40px;">
                                    {{ substr($sub->user->name ?? 'G', 0, 1) }}
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">{{ $sub->user->name ?? 'Guest User' }}</div>
                                    <div class="small text-muted">{{ $sub->user->email ?? 'No Email' }}</div>
                                </div>
                            </div>
                        </td>
                        
                        <td>
                            <div class="fw-bold text-dark">{{ $sub->form->name ?? 'Unknown Form' }}</div>
                            @if($sub->form->amount > 0)
                                <span class="badge bg-light text-dark border">${{ number_format($sub->form->amount, 2) }} Fee</span>
                            @else
                                <span class="badge bg-light text-muted border">Free Application</span>
                            @endif
                        </td>

                        <td>
                            @if($sub->status == 'approved')
                                <span class="badge bg-success bg-opacity-10 text-success border border-success px-3 rounded-pill">Approved</span>
                            @elseif($sub->status == 'pending')
                                <span class="badge bg-warning bg-opacity-10 text-warning border border-warning px-3 rounded-pill">Pending</span>
                            @elseif($sub->status == 'rejected')
                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger px-3 rounded-pill">Rejected</span>
                            @else
                                <span class="badge bg-secondary px-3 rounded-pill">{{ ucfirst($sub->status) }}</span>
                            @endif
                        </td>

                        <td class="text-muted">
                            {{ $sub->created_at->format('M d, Y') }}
                        </td>

                        <td class="text-end pe-4">
                            <button class="btn btn-sm btn-outline-primary rounded-pill px-3" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#sub{{$sub->id}}">
                                View
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="bi bi-inbox fs-1 opacity-25"></i>
                            <p class="mt-2">No applications found for this period.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- MODALS FOR VIEWING DETAILS --}}
@foreach($recent_requests as $sub)
    <div class="modal fade" id="sub{{$sub->id}}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header bg-primary text-white">
                    <div>
                        <h5 class="modal-title fw-bold">Application Details</h5>
                        <p class="mb-0 small opacity-75">Applicant: {{ $sub->user->name ?? 'Guest' }}</p>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                
                <div class="modal-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4 w-50">Question</th>
                                    <th class="w-50">Answer</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php 
                                    $data = json_decode($sub->data, true); 
                                @endphp
                                @foreach($data as $key => $value)
                                    @php
                                        // Clean answer (remove score string if present for display)
                                        $cleanAnswer = preg_replace('/\(Score: \d+\)/', '', $value);
                                    @endphp
                                    <tr>
                                        <td class="ps-4 fw-bold text-dark">{{ $key }}</td>
                                        <td class="text-muted">{{ $cleanAnswer }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a href="{{ route('admin.applicants') }}" class="btn btn-primary">Go to Full Management</a>
                </div>
            </div>
        </div>
    </div>
@endforeach

@endsection