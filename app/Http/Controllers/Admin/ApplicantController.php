<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ApplicantController extends Controller
{

    public function index()
    {
        $submissions = Submission::with([])->get();
        return view('admin.applicants', compact('submissions'));
    }

    public function approveSubmission($id)
    {
        $submission = Submission::findOrFail($id);
        $submission->status = 'approved';
        $submission->save();

        return back()->with('success', 'Application Approved Successfully');
    }

    // 3. Reject Logic
    public function rejectSubmission($id)
    {
        $submission = Submission::findOrFail($id);
        $submission->status = 'rejected';
        $submission->save();

        return back()->with('success', 'Application Rejected');
    }

    /**
     * Parse a submission's stored JSON data into a clean list of
     * ['question' => ..., 'answer' => ..., 'score' => ...] rows plus the total.
     */
    private function parseSubmissionData($submission): array
    {
        $rawData = json_decode($submission->data, true) ?? [];
        $parsedData = [];
        $totalCalculated = 0;

        foreach ($rawData as $label => $answerString) {
            // Extract Score using Regex
            preg_match('/\(Score: (\d+)\)/', $answerString, $matches);
            $score = isset($matches[1]) ? (int) $matches[1] : 0;

            // Clean Answer Text (strip the trailing "(Score: X)" marker)
            $cleanAnswer = trim(preg_replace('/\(Score: \d+\)/', '', $answerString));

            $parsedData[] = [
                'question' => $label,
                'answer' => $cleanAnswer,
                'score' => $score
            ];
            $totalCalculated += $score;
        }

        return ['items' => $parsedData, 'total' => $totalCalculated];
    }

    /**
     * Full detail page for a single application with editable scores.
     */
    public function showSubmission($id)
    {
        $submission = Submission::with(['user', 'form'])->findOrFail($id);
        $parsed = $this->parseSubmissionData($submission);

        return view('admin.applicant-details', [
            'submission' => $submission,
            'items' => $parsed['items'],
            'totalCalculated' => $parsed['total'],
        ]);
    }

    /**
     * Stream a nicely designed PDF of a single application submission.
     */
    public function downloadPdf($id)
    {
        $submission = Submission::with(['user', 'form'])->findOrFail($id);
        $parsed = $this->parseSubmissionData($submission);

        // Embed the brand logo as a base64 data URI so DomPDF never has to
        // hit the filesystem/network at render time (cPanel-safe).
        $logoPath = public_path('assets/images/cig-logo-pdf.png');
        $logoData = is_file($logoPath)
            ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath))
            : null;

        $pdf = Pdf::loadView('admin.applicant-pdf', [
            'submission' => $submission,
            'items' => $parsed['items'],
            'totalCalculated' => $parsed['total'],
            'logoData' => $logoData,
            'generatedAt' => now(),
        ])->setPaper('a4', 'portrait');

        $applicant = Str::slug($submission->user->name ?? 'guest');
        $fileName = "application-{$applicant}-{$submission->id}.pdf";

        return $pdf->download($fileName);
    }

    public function getSubmissionDetails($id)
    {
        $submission = Submission::with('user')->findOrFail($id);
        $parsed = $this->parseSubmissionData($submission);

        return response()->json([
            'submission_id' => $submission->id,
            'applicant_name' => $submission->user->name ?? 'Guest',
            'items' => $parsed['items'],
            'total_score' => $parsed['total'],
            // We also send the update URL so the form knows where to submit
            'update_url' => route('admin.update_score', $submission->id)
        ]);
    }

    public function updateScore(Request $request, $id)
    {
        $submission = Submission::findOrFail($id);
        $currentData = json_decode($submission->data, true);
        $newScores = $request->input('scores'); // Array of [Label => NewScore]

        $updatedData = [];
        $newTotalScore = 0;

        foreach ($currentData as $label => $answerString) {
            // 1. Get the new score for this question (default to 0 if not set)
            // We use underscores in form names, so we might need to match keys carefully
            // But simpler is to rely on the exact key passed from the form
            $scoreToApply = isset($newScores[$label]) ? (int) $newScores[$label] : 0;

            // 2. Update the Text String
            // If the answer already has "(Score: X)", replace it.
            if (preg_match('/\(Score: \d+\)/', $answerString)) {
                $updatedString = preg_replace('/\(Score: \d+\)/', "(Score: $scoreToApply)", $answerString);
            } else {
                // If it didn't have a score before (e.g. text field), append it
                $updatedString = $answerString . " (Score: $scoreToApply)";
            }

            // 3. Save to array and add to total
            $updatedData[$label] = $updatedString;
            $newTotalScore += $scoreToApply;
        }

        // 4. Save to Database
        $submission->update([
            'data' => json_encode($updatedData),
            'total_score' => $newTotalScore
        ]);

        return back()->with('success', 'Scores updated and recalculated successfully!');
    }
}
