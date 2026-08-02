@component('mail::message')
# New application submitted

A new application has been submitted for **{{ $formName }}**.

- Applicant: **{{ $applicantName }}**
- Submitted at: **{{ $submittedAt }}**
- Submission ID: **#{{ $submission->id }}**

The attached PDF contains the full application details.

Thanks,
{{ config('app.name') }}
@endcomponent
