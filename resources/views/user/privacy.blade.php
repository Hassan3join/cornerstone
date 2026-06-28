@extends('user.layouts.app')

@section('title', 'Privacy Policy — Cornerstone Investment Group')

@section('content')
    <header class="py-5" style="background: linear-gradient(135deg,#0D4EA3 0%,#2F5870 100%);">
        <div class="container py-4 text-center text-white">
            <span class="badge-cig mb-3">Legal</span>
            <h1 class="text-white mb-2" style="font-size:2.6rem;">Privacy Policy</h1>
            <p class="mb-0" style="opacity:.85;">How Cornerstone Investment Group handles your information.</p>
        </div>
    </header>

    <section class="section">
        <div class="container" style="max-width: 860px;">
            <div class="cig-card p-4 p-md-5">
                <p class="text-cig-muted small mb-4">Last updated: {{ date('F Y') }}</p>

                <h4 class="mt-0">1. Introduction</h4>
                <p class="text-cig-muted">
                    Cornerstone Investment Group, LLC ("Cornerstone," "we," "us") respects your privacy.
                    This policy explains what information we collect through this website and our borrower
                    application process, and how we use and protect it.
                </p>

                <h4 class="mt-4">2. Information We Collect</h4>
                <p class="text-cig-muted">
                    We collect information you provide directly when you create an account or submit a loan
                    application — such as your name, contact details, entity information, project and property
                    details, and financial information relevant to underwriting your request.
                </p>

                <h4 class="mt-4">3. How We Use Your Information</h4>
                <ul class="text-cig-muted">
                    <li>To review, underwrite, and respond to your funding request.</li>
                    <li>To communicate with you about your application and account.</li>
                    <li>To verify identity, prevent fraud, and meet legal or regulatory obligations.</li>
                    <li>To operate, maintain, and improve our services.</li>
                </ul>

                <h4 class="mt-4">4. Sharing of Information</h4>
                <p class="text-cig-muted">
                    We do not sell your personal information. We may share information with service providers
                    who support our operations (such as payment processing) and where required by law or to
                    protect our legal rights.
                </p>

                <h4 class="mt-4">5. Payments</h4>
                <p class="text-cig-muted">
                    Where a fee applies, payments are processed securely by our third-party payment processor.
                    We do not store full card details on our servers.
                </p>

                <h4 class="mt-4">6. Data Security</h4>
                <p class="text-cig-muted">
                    We use reasonable administrative and technical safeguards to protect your information.
                    No method of transmission or storage is completely secure, however, and we cannot
                    guarantee absolute security.
                </p>

                <h4 class="mt-4">7. Your Choices</h4>
                <p class="text-cig-muted">
                    You may request access to, correction of, or deletion of your account information by
                    contacting us using the details below.
                </p>

                <h4 class="mt-4">8. Contact Us</h4>
                <p class="text-cig-muted mb-0">
                    Questions about this policy? Email
                    <a class="auth-link" href="mailto:info@cornerstoneinvestmentgroup.com">info@cornerstoneinvestmentgroup.com</a>.
                </p>
            </div>

            <p class="text-center small text-cig-muted mt-4">
                This page is provided for general information and is not legal advice. Please review with your
                own counsel before relying on it.
            </p>
        </div>
    </section>
@endsection
