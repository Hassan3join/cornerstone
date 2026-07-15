@php
    $statusStyles = [
        'pending'  => ['bg' => '#fff7ed', 'fg' => '#c2610c', 'bd' => '#fdba74', 'label' => 'Pending'],
        'approved' => ['bg' => '#ecfdf5', 'fg' => '#15803d', 'bd' => '#86efac', 'label' => 'Approved'],
        'rejected' => ['bg' => '#fef2f2', 'fg' => '#b91c1c', 'bd' => '#fca5a5', 'label' => 'Rejected'],
    ];
    $st = $statusStyles[$submission->status] ?? ['bg' => '#f3f4f6', 'fg' => '#374151', 'bd' => '#d1d5db', 'label' => ucfirst($submission->status)];
    $applicantName = $submission->user->name ?? 'Guest Applicant';
    $applicantEmail = $submission->user->email ?? '—';
    $formName = $submission->form->name ?? 'Loan Application';
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <style>
        @page {
            margin: 130px 40px 70px 40px;
        }

        * { font-family: DejaVu Sans, sans-serif; }

        body {
            margin: 0;
            padding: 0;
            color: #1f2937;
            font-size: 12px;
            line-height: 1.55;
        }

        /* ---------- Fixed header (repeats on every page) ---------- */
        .page-header {
            position: fixed;
            top: -110px;
            left: 0;
            right: 0;
            height: 100px;
        }
        .header-table { width: 100%; border-collapse: collapse; }
        .header-table td { vertical-align: middle; }
        .header-logo { width: 165px; }
        .header-logo img { height: 52px; }
        .header-meta {
            text-align: right;
            font-size: 10px;
            color: #6b7280;
        }
        .header-meta .doc-title {
            font-size: 15px;
            font-weight: bold;
            color: #4f46e5;
            letter-spacing: .3px;
        }
        .header-rule {
            height: 3px;
            background: #4f46e5;
            margin-top: 10px;
        }
        .header-rule-soft {
            height: 1px;
            background: #e5e7eb;
            margin-top: 2px;
        }

        /* ---------- Fixed footer (repeats on every page) ---------- */
        .page-footer {
            position: fixed;
            bottom: -50px;
            left: 0;
            right: 0;
            height: 40px;
            font-size: 9px;
            color: #9ca3af;
            border-top: 1px solid #e5e7eb;
            padding-top: 8px;
        }
        .footer-table { width: 100%; border-collapse: collapse; }
        .footer-table td { vertical-align: middle; }
        .footer-right { text-align: right; }
        .page-number:after { content: counter(page); }
        .page-count:after  { content: counter(pages); }

        /* ---------- Applicant summary card ---------- */
        .summary {
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            background: #fafafe;
            padding: 0;
            margin-bottom: 22px;
        }
        .summary-top {
            background: #4f46e5;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            padding: 12px 16px;
        }
        .summary-top .name {
            color: #ffffff;
            font-size: 17px;
            font-weight: bold;
        }
        .summary-top .sub {
            color: #d7d9ff;
            font-size: 10px;
            margin-top: 2px;
        }
        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: bold;
            background: {{ $st['bg'] }};
            color: {{ $st['fg'] }};
            border: 1px solid {{ $st['bd'] }};
        }
        .info-table { width: 100%; border-collapse: collapse; }
        .info-table td {
            padding: 10px 16px;
            width: 33.33%;
            vertical-align: top;
            border-top: 1px solid #eef0f4;
        }
        .info-label {
            font-size: 8.5px;
            letter-spacing: .7px;
            text-transform: uppercase;
            color: #9aa1ac;
            font-weight: bold;
        }
        .info-value {
            font-size: 12px;
            color: #1f2937;
            margin-top: 2px;
        }
        .score-big {
            font-size: 20px;
            font-weight: bold;
            color: #4f46e5;
        }

        /* ---------- Section heading ---------- */
        .section-head {
            font-size: 13px;
            font-weight: bold;
            color: #111827;
            border-left: 4px solid #4f46e5;
            padding-left: 8px;
            margin-bottom: 12px;
        }
        .section-count { color: #9ca3af; font-weight: normal; font-size: 10px; }

        /* ---------- Q/A cards ---------- */
        .qa {
            border: 1px solid #e9eaf2;
            border-radius: 8px;
            margin-bottom: 10px;
            padding: 0;
        }
        .qa-table { width: 100%; border-collapse: collapse; }
        .qa-body { padding: 11px 14px; vertical-align: top; }
        .qa-score-cell {
            width: 74px;
            padding: 11px 10px;
            vertical-align: top;
            border-left: 1px solid #eef0f4;
            text-align: center;
        }
        .qa-num {
            color: #4f46e5;
            font-weight: bold;
            font-size: 10px;
        }
        .qa-label {
            font-size: 8.5px;
            letter-spacing: .6px;
            text-transform: uppercase;
            color: #9aa1ac;
            font-weight: bold;
        }
        .qa-question {
            font-size: 12px;
            font-weight: bold;
            color: #1f2937;
            margin: 1px 0 8px 0;
        }
        .qa-answer {
            font-size: 11.5px;
            color: #374151;
        }
        .score-chip {
            display: inline-block;
            min-width: 26px;
            padding: 5px 8px;
            border-radius: 6px;
            background: #eef0ff;
            color: #4f46e5;
            font-weight: bold;
            font-size: 13px;
        }
        .empty {
            text-align: center;
            color: #9ca3af;
            padding: 30px;
            border: 1px dashed #d1d5db;
            border-radius: 8px;
        }
    </style>
</head>
<body>

    {{-- ===== Repeating header ===== --}}
    <div class="page-header">
        <table class="header-table">
            <tr>
                <td class="header-logo">
                    @if($logoData)
                        <img src="{{ $logoData }}" alt="Cornerstone Investment Group">
                    @else
                        <span style="font-size:16px;font-weight:bold;color:#4f46e5;">CORNERSTONE</span>
                    @endif
                </td>
                <td class="header-meta">
                    <div class="doc-title">Loan Application Submission</div>
                    <div>Reference #{{ str_pad($submission->id, 5, '0', STR_PAD_LEFT) }}</div>
                    <div>Generated {{ $generatedAt->format('M d, Y \a\t g:i A') }}</div>
                </td>
            </tr>
        </table>
        <div class="header-rule"></div>
        <div class="header-rule-soft"></div>
    </div>

    {{-- ===== Repeating footer ===== --}}
    <div class="page-footer">
        <table class="footer-table">
            <tr>
                <td>Cornerstone Investment Group, LLC &nbsp;&bull;&nbsp; Confidential</td>
                <td class="footer-right">Page <span class="page-number"></span> of <span class="page-count"></span></td>
            </tr>
        </table>
    </div>

    {{-- ===== Applicant summary ===== --}}
    <div class="summary">
        <table class="summary-top" style="width:100%; border-collapse:collapse;">
            <tr>
                <td style="vertical-align:middle;">
                    <div class="name">{{ $applicantName }}</div>
                    <div class="sub">{{ $formName }}</div>
                </td>
                <td style="text-align:right; vertical-align:middle;">
                    <span class="badge">{{ $st['label'] }}</span>
                </td>
            </tr>
        </table>

        <table class="info-table">
            <tr>
                <td>
                    <div class="info-label">Email</div>
                    <div class="info-value">{{ $applicantEmail }}</div>
                </td>
                <td>
                    <div class="info-label">Submitted On</div>
                    <div class="info-value">{{ optional($submission->created_at)->format('M d, Y') ?? '—' }}</div>
                </td>
                <td>
                    <div class="info-label">Total Score</div>
                    <div class="score-big">{{ $submission->total_score }}</div>
                </td>
            </tr>
        </table>
    </div>

    {{-- ===== Answers ===== --}}
    <div class="section-head">
        Application Answers
        <span class="section-count">— {{ count($items) }} {{ Str::plural('question', count($items)) }}</span>
    </div>

    @forelse($items as $i => $item)
        <div class="qa">
            <table class="qa-table">
                <tr>
                    <td class="qa-body">
                        <div class="qa-num">Q{{ $i + 1 }}</div>
                        <div class="qa-question">{{ $item['question'] }}</div>
                        <div class="qa-label">Answer</div>
                        <div class="qa-answer">{{ $item['answer'] !== '' ? $item['answer'] : '—' }}</div>
                    </td>
                    <td class="qa-score-cell">
                        <div class="qa-label" style="margin-bottom:5px;">Score</div>
                        <span class="score-chip">{{ $item['score'] }}</span>
                    </td>
                </tr>
            </table>
        </div>
    @empty
        <div class="empty">No answers were recorded for this application.</div>
    @endforelse

</body>
</html>
