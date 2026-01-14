<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Form;
use App\Models\QuestionOption;
use App\Models\Submission;
use App\Models\Transaction;
use App\Services\StripeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FormSubmissionController extends Controller
{
    public function initiatePayment($formId, StripeService $stripe)
    {
        $form = Form::findOrFail($formId);

        if ($form->amount <= 0) {
            return response()->json(['message' => 'No payment needed'], 200);
        }

        try {
            // Create Intent Only When Asked
            $intent = $stripe->createPaymentIntent($form->amount, $form->currency, [
                'form_id' => $form->id,
                'user_id' => auth()->id()
            ]);

            return response()->json([
                'client_secret' => $intent->client_secret
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function submit(Request $request, $formId, StripeService $stripe)
    {
        try {
            $form = Form::with('items.question.options')->findOrFail($formId);
            $totalScore = 0;
            $submissionData = [];

            $paymentStatus = 'skipped';
            $transactionId = null;

            if ($form->amount > 0) {
                $paymentIntentId = $request->input('payment_intent_id');

                if (!$paymentIntentId) {
                    return back()->with('error', 'Payment failed or missing.');
                }

                $verifiedParams = $stripe->verifyPayment($paymentIntentId);

                if (!$verifiedParams) {
                    return back()->with('error', 'Payment verification failed.');
                }

                $paymentStatus = 'succeeded';
                $transactionId = $verifiedParams->id;
            }

            foreach ($form->items as $item) {
                $fieldName = 'field_' . $item->id;
                $inputValue = $request->input($fieldName); // Can be String or Array (for checkbox)

                // 1. SCORABLE QUESTION
                if ($item->type === 'question' && $item->question) {
                    $q = $item->question;

                    // CASE A: TEXT QUESTION
                    if ($q->type === 'text') {
                        if (!empty($inputValue)) {
                            $totalScore += $q->score; // Add base score
                            $submissionData[$item->label] = $inputValue . " (Score: {$q->score})";
                        } else {
                            $submissionData[$item->label] = "No Answer";
                        }
                    }
                    // CASE B: RADIO (Single ID)
                    elseif ($q->type === 'radio') {
                        $option = QuestionOption::find($inputValue);
                        if ($option) {
                            $totalScore += $option->score;
                            $submissionData[$item->label] = $option->option_text . " (Score: {$option->score})";
                        }
                    }
                    // CASE C: CHECKBOX (Array of IDs)
                    elseif ($q->type === 'checkbox' && is_array($inputValue)) {
                        $options = QuestionOption::whereIn('id', $inputValue)->get();
                        $sum = $options->sum('score');
                        $names = $options->pluck('option_text')->implode(', ');

                        $totalScore += $sum;
                        $submissionData[$item->label] = $names . " (Score: {$sum})";
                    }
                }
                // 2. STANDARD FORM FIELDS (Created in builder, not bank)
                else {
                    $submissionData[$item->label] = is_array($inputValue) ? implode(', ', $inputValue) : $inputValue;
                }
            }

            $submission = Submission::create([
                'form_id' => $form->id,
                'user_id' => auth()->id(),
                'total_score' => $totalScore,
                'status' => 'pending',
                'data' => json_encode($submissionData),
            ]);

            // 4. Record Transaction (If Paid)
            if ($transactionId) {
                Transaction::create([
                    'user_id' => auth()->id(),
                    'form_id' => $form->id,
                    'submission_id' => $submission->id,
                    'transaction_id' => $transactionId,
                    'amount' => $form->amount,
                    'currency' => $form->currency,
                    'status' => 'succeeded'
                ]);
            }

            return back()->with('success', 'Application Submitted Successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
