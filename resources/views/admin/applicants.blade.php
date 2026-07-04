@extends('admin.layouts.app')

@section('content')
    <div class="card-custom p-0 overflow-hidden">
        <div class="p-4 border-bottom d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">Pending Applications</h5>
            <button class="btn btn-primary btn-sm"><i class="bi bi-download me-1"></i> Export CSV</button>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">User</th>
                        <th>Form Name</th>
                        <th>Score</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($submissions as $sub)
                        <tr>
                            <td class="ps-4 fw-bold">{{ $sub->user->name ?? 'Guest' }}</td>
                            <td>{{ $sub->form->name }}</td>
                            <td><span class="badge bg-primary">{{ $sub->total_score }}</span></td>
                            <td>{{ ucfirst($sub->status) }}</td>
                            <td>
                                <a href="{{ route('admin.applicant_show', $sub->id) }}"
                                   class="btn btn-sm btn-info text-white">
                                    <i class="bi bi-eye me-1"></i> View Answers
                                </a>

                                @if ($sub->status == 'pending')
                                    <a href="{{ route('admin.approve', $sub->id) }}" class="btn btn-sm btn-success">Accept</a>
                                    <a href="{{ route('admin.reject', $sub->id) }}" class="btn btn-sm btn-danger">Reject</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection