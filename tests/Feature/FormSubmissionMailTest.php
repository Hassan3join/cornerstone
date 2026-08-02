<?php

namespace Tests\Feature;

use App\Mail\ApplicationSubmittedMail;
use App\Models\Form;
use App\Models\FormItem;
use App\Models\Question;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class FormSubmissionMailTest extends TestCase
{
    use RefreshDatabase;

    public function test_application_submission_sends_an_admin_email_with_pdf_attachment(): void
    {
        Mail::fake();

        $user = User::factory()->create();
        $form = Form::create([
            'name' => 'Loan Application',
            'submit_btn_text' => 'Submit',
            'btn_color' => '#2563eb',
        ]);

        $question = Question::create(['title' => 'What is your monthly income?']);
        $item = FormItem::create([
            'form_id' => $form->id,
            'type' => 'question',
            'label' => $question->title,
            'question_id' => $question->id,
            'order_index' => 1,
        ]);

        $response = $this->actingAs($user)->post(route('form.submit', $form->id), [
            'field_' . $item->id => '50000',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Application Submitted Successfully!');

        $submission = Submission::latest('id')->first();
        $this->assertNotNull($submission);

        $recipient = env('ADMIN_EMAIL', config('mail.from.address'));

        Mail::assertSent(ApplicationSubmittedMail::class, function (ApplicationSubmittedMail $mail) use ($recipient, $submission): bool {
            return $mail->hasTo($recipient)
                && $mail->submission->id === $submission->id;
        });
    }
}
