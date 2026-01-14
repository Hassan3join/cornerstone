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
                                <button class="btn btn-sm btn-info text-white view-btn" 
                                        data-id="{{ $sub->id }}" 
                                        onclick="openApplicationModal(this)">
                                    View Answers
                                </button>
                                
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

    <div class="modal fade" id="applicationModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                
                <div class="modal-header bg-primary text-white">
                    <div>
                        <h5 class="modal-title fw-bold">Review Application</h5>
                        <p class="mb-0 small opacity-75" id="modalApplicantName">Loading...</p>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <form id="scoreForm" method="POST" onsubmit="return confirmSubmission()">
                    @csrf
                    
                    <div class="modal-body p-0">
                        <div id="modalLoader" class="text-center py-5">
                            <div class="spinner-border text-primary" role="status"></div>
                            <p class="mt-2 text-muted">Fetching application details...</p>
                        </div>

                        <div id="modalContent" class="table-responsive d-none">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4" style="width: 40%;">Question</th>
                                        <th style="width: 40%;">Answer</th>
                                        <th class="text-center" style="width: 20%;">Score</th>
                                    </tr>
                                </thead>
                                <tbody id="modalTableBody">
                                    </tbody>
                                <tfoot class="bg-light fw-bold">
                                    <tr>
                                        <td colspan="2" class="text-end pe-3">Total Calculated:</td>
                                        <td class="text-center text-primary" id="modalTotalScore">0</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary px-4" id="submitBtn" disabled>
                            <i class="bi bi-save me-1"></i> Update & Recalculate
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection

@push('js')
<script>
    function confirmSubmission() {
        return confirm("Are you sure you want to update these scores?");
    }

    function openApplicationModal(button) {
        // 1. Get ID and Elements
        const id = button.getAttribute('data-id');
        const modalEl = document.getElementById('applicationModal');
        const loader = document.getElementById('modalLoader');
        const content = document.getElementById('modalContent');
        const tableBody = document.getElementById('modalTableBody');
        const form = document.getElementById('scoreForm');
        const submitBtn = document.getElementById('submitBtn');
        const nameLabel = document.getElementById('modalApplicantName');
        
        // 2. Show Modal & Reset State
        const modal = new bootstrap.Modal(modalEl);
        modal.show();
        
        loader.classList.remove('d-none');
        content.classList.add('d-none');
        submitBtn.disabled = true;
        tableBody.innerHTML = ''; // Clear previous data

        // 3. Fetch Data from API
        fetch(`/admin/applicants/details/${id}`)
            .then(response => response.json())
            .then(data => {
                // Update Static Info
                nameLabel.innerText = "Applicant: " + data.applicant_name;
                form.action = data.update_url; // Set form submission URL dynamically
                document.getElementById('modalTotalScore').innerText = data.total_score;

                // Loop through items and build HTML
                let rowsHtml = '';
                data.items.forEach(item => {
                    rowsHtml += `
                        <tr>
                            <td class="ps-4 fw-bold text-dark">${item.question}</td>
                            <td class="text-muted text-wrap" style="max-width: 300px;">${item.answer}</td>
                            <td class="pe-3">
                                <input type="number" 
                                       name="scores[${item.question}]" 
                                       value="${item.score}" 
                                       class="form-control text-center fw-bold score-input">
                            </td>
                        </tr>
                    `;
                });

                // Update DOM
                tableBody.innerHTML = rowsHtml;
                
                // Show Content
                loader.classList.add('d-none');
                content.classList.remove('d-none');
                submitBtn.disabled = false;
            })
            .catch(error => {
                alert('Error fetching data');
                console.error(error);
                modal.hide();
            });
    }

    // Dynamic Total Calculation (Event Delegation)
    document.addEventListener('input', function (e) {
        if (e.target.classList.contains('score-input')) {
            let total = 0;
            document.querySelectorAll('.score-input').forEach(input => {
                total += parseInt(input.value) || 0;
            });
            document.getElementById('modalTotalScore').innerText = total;
        }
    });
</script>
@endpush