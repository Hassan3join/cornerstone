<?php

namespace App\Mail;

use App\Models\Submission;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;

class ApplicationSubmittedMail extends Mailable
{
    use Queueable;

    public Submission $submission;

    public string $pdfContent;

    public string $pdfFileName;

    public function __construct(Submission $submission, string $pdfContent, string $pdfFileName)
    {
        $this->submission = $submission;
        $this->pdfContent = $pdfContent;
        $this->pdfFileName = $pdfFileName;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New application submitted: ' . ($this->submission->form->name ?? 'Application'),
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.application-submitted',
            with: [
                'submission' => $this->submission,
                'applicantName' => $this->submission->user->name ?? 'Guest Applicant',
                'formName' => $this->submission->form->name ?? 'Application',
                'submittedAt' => $this->submission->created_at->format('M d, Y \a\t g:i A'),
            ],
        );
    }

    public function attachments(): array
    {
        return [
            Attachment::fromData(fn () => $this->pdfContent, $this->pdfFileName)
                ->withMime('application/pdf'),
        ];
    }
}
