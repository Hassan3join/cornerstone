<?php

namespace App\Services;

use App\Models\Submission;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class ApplicationPdfService
{
    public function generatePdf(Submission $submission): string
    {
        $parsed = $this->parseSubmissionData($submission);

        $logoPath = public_path('assets/images/cig-logo-pdf.png');
        $logoData = is_file($logoPath)
            ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath))
            : null;

        return Pdf::loadView('admin.applicant-pdf', [
            'submission' => $submission,
            'items' => $parsed['items'],
            'totalCalculated' => $parsed['total'],
            'logoData' => $logoData,
            'generatedAt' => now(),
        ])->setPaper('a4', 'portrait')->output();
    }

    public function getFileName(Submission $submission): string
    {
        $applicant = Str::slug($submission->user->name ?? 'guest');

        return "application-{$applicant}-{$submission->id}.pdf";
    }

    private function parseSubmissionData(Submission $submission): array
    {
        $rawData = json_decode($submission->data, true) ?? [];
        $parsedData = [];
        $totalCalculated = 0;

        foreach ($rawData as $label => $answerString) {
            preg_match('/\(Score: (\d+)\)/', $answerString, $matches);
            $score = isset($matches[1]) ? (int) $matches[1] : 0;
            $cleanAnswer = trim(preg_replace('/\(Score: \d+\)/', '', $answerString));

            $parsedData[] = [
                'question' => $label,
                'answer' => $cleanAnswer,
                'score' => $score,
            ];
            $totalCalculated += $score;
        }

        return ['items' => $parsedData, 'total' => $totalCalculated];
    }
}
