@extends('admin.layouts.app')

@php
    $statusColors = [
        'pending' => 'warning',
        'approved' => 'success',
        'rejected' => 'danger',
    ];
    $statusColor = $statusColors[$submission->status] ?? 'secondary';
@endphp

@section('content')
    <style>
        .applicant-hero {
            background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
            border-radius: 14px;
            color: #fff;
        }
        .qa-card {
            border: 1px solid #eef0f4;
            border-radius: 12px;
            background: #fff;
            transition: box-shadow .2s ease, border-color .2s ease;
        }
        .qa-card:hover {
            border-color: #d7d9ff;
            box-shadow: 0 4px 14px rgba(79, 70, 229, .06);
        }
        .qa-label {
            font-size: 11px;
            letter-spacing: .6px;
            text-transform: uppercase;
            font-weight: 700;
            color: #9aa1ac;
        }
        .qa-answer {
            color: #374151;
            white-space: pre-wrap;   /* keep line breaks, wrap long text */
            word-break: break-word;  /* never overflow the card */
            line-height: 1.6;
        }
        .score-input {
            max-width: 110px;
            font-weight: 700;
            text-align: center;
            border: 2px solid #eef0f4;
        }
        .score-input:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 .2rem rgba(79, 70, 229, .12);
        }
        .summary-bar {
            position: sticky;
            bottom: 20px;
            z-index: 5;
        }
        .total-pill {
            background: #eef0ff;
            color: #4f46e5;
            border-radius: 10px;
            font-weight: 700;
        }
    </style>

    {{-- Back link --}}
    <div class="mb-3">
        <a href="{{ route('admin.applicants') }}" class="text-decoration-none text-muted small fw-bold">
            <i class="bi bi-arrow-left me-1"></i> Back to Applicants
        </a>
    </div>

    {{-- Hero / applicant summary --}}
    <div class="applicant-hero p-4 mb-4 shadow-sm">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div class="d-flex align-items-center gap-3">
                <div class="d-flex align-items-center justify-content-center rounded-circle bg-white text-primary fw-bold"
                     style="width: 56px; height: 56px; font-size: 1.4rem; color:#4f46e5 !important;">
                    {{ strtoupper(substr($submission->user->name ?? 'G', 0, 1)) }}
                </div>
                <div>
                    <h4 class="fw-bold mb-1">{{ $submission->user->name ?? 'Guest' }}</h4>
                    <div class="opacity-75 small">
                        <i class="bi bi-file-earmark-text me-1"></i>{{ $submission->form->name ?? 'Unknown Form' }}
                        <span class="mx-2">•</span>
                        <i class="bi bi-envelope me-1"></i>{{ $submission->user->email ?? '—' }}
                    </div>
                </div>
            </div>
            <div class="text-lg-end">
                <span class="badge bg-{{ $statusColor }} rounded-pill px-3 py-2 text-capitalize mb-2">
                    {{ $submission->status }}
                </span>
                <div class="opacity-75 small">Current Total Score</div>
                <div class="fs-3 fw-bold">{{ $submission->total_score }}</div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.update_score', $submission->id) }}" method="POST"
          onsubmit="return confirm('Are you sure you want to update these scores?');">
        @csrf

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold mb-0">Application Answers</h5>
            <span class="text-muted small">{{ count($items) }} {{ Str::plural('question', count($items)) }}</span>
        </div>

        @forelse($items as $item)
            <div class="qa-card p-3 p-md-4 mb-3">
                <div class="row g-3 align-items-start">
                    <div class="col-md-9">
                        <div class="qa-label mb-1">Question</div>
                        <div class="fw-bold text-dark mb-3">{{ $item['question'] }}</div>

                        <div class="qa-label mb-1">Answer</div>
                        <div class="qa-answer">{{ $item['answer'] !== '' ? $item['answer'] : '—' }}</div>
                    </div>
                    <div class="col-md-3">
                        <label class="qa-label d-block mb-1">Score</label>
                        <input type="number"
                               name="scores[{{ $item['question'] }}]"
                               value="{{ $item['score'] }}"
                               class="form-control score-input">
                    </div>
                </div>
            </div>
        @empty
            <div class="card-custom p-5 text-center text-muted">
                <i class="bi bi-inbox display-5 d-block mb-2"></i>
                No answers were recorded for this application.
            </div>
        @endforelse

        {{-- Sticky summary + actions --}}
        @if(count($items) > 0)
            <div class="summary-bar card-custom p-3 mt-4">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                    <div class="d-flex align-items-center gap-2">
                        <span class="text-muted fw-bold">Total Calculated:</span>
                        <span class="total-pill px-3 py-2 fs-5" id="totalScore">{{ $totalCalculated }}</span>
                    </div>
                    <div class="d-flex gap-2">
                        @if($submission->status == 'pending')
                            <a href="{{ route('admin.approve', $submission->id) }}"
                               class="btn btn-success"
                               onclick="return confirm('Approve this application?');">
                                <i class="bi bi-check-lg me-1"></i> Accept
                            </a>
                            <a href="{{ route('admin.reject', $submission->id) }}"
                               class="btn btn-outline-danger"
                               onclick="return confirm('Reject this application?');">
                                <i class="bi bi-x-lg me-1"></i> Reject
                            </a>
                        @endif
                        <button type="submit" class="btn btn-primary px-4" style="background:#4f46e5; border-color:#4f46e5;">
                            <i class="bi bi-save me-1"></i> Update &amp; Recalculate
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </form>
@endsection

@push('js')
<script>
    // Live total as scores are edited
    document.addEventListener('input', function (e) {
        if (e.target.classList.contains('score-input')) {
            let total = 0;
            document.querySelectorAll('.score-input').forEach(input => {
                total += parseInt(input.value, 10) || 0;
            });
            const el = document.getElementById('totalScore');
            if (el) el.innerText = total;
        }
    });
</script>
@endpush
