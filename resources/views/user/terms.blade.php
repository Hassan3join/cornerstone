@extends('user.layouts.app')

@section('title', 'Terms of Use — Cornerstone Investment Group')

@section('content')
    <header class="py-5" style="background: linear-gradient(135deg,#0D4EA3 0%,#2F5870 100%);">
        <div class="container py-4 text-center text-white">
            <span class="badge-cig mb-3">Legal</span>
            <h1 class="text-white mb-2" style="font-size:2.6rem;">Terms of Use</h1>
            <p class="mb-0" style="opacity:.85;">The terms that govern your use of this website.</p>
        </div>
    </header>

    <section class="section">
        <div class="container" style="max-width: 860px;">
            <div class="cig-card p-4 p-md-5">
                <p class="text-cig-muted small mb-4">Last updated: {{ date('F Y') }}</p>

                <h4 class="mt-0">1. Acceptance of Terms</h4>
                <p class="text-cig-muted">
                    By accessing or using this website operated by Cornerstone Investment Group, LLC, you agree
                    to these Terms of Use. If you do not agree, please do not use the site.
                </p>

                <h4 class="mt-4">2. Not a Commitment to Lend</h4>
                <p class="text-cig-muted">
                    Information on this website is for general informational purposes and does not constitute an
                    offer or commitment to lend. All funding is subject to underwriting, approval, collateral
                    review, and final loan documents. Terms and availability may vary.
                </p>

                <h4 class="mt-4">3. Eligibility &amp; Accounts</h4>
                <p class="text-cig-muted">
                    You must be legally able to enter into contracts to use our application services. You are
                    responsible for the accuracy of the information you submit and for maintaining the
                    confidentiality of your account credentials.
                </p>

                <h4 class="mt-4">4. Applications &amp; Fees</h4>
                <p class="text-cig-muted">
                    Submitting an application does not guarantee funding. Where an application or service fee
                    applies, it will be shown before payment. Fees are processed through a secure third-party
                    payment provider.
                </p>

                <h4 class="mt-4">5. Acceptable Use</h4>
                <p class="text-cig-muted">
                    You agree not to misuse the site, submit false information, or attempt to disrupt or gain
                    unauthorized access to our systems.
                </p>

                <h4 class="mt-4">6. Intellectual Property</h4>
                <p class="text-cig-muted">
                    The Cornerstone Investment Group name, logo, and site content are the property of Cornerstone
                    Investment Group, LLC and may not be used without permission.
                </p>

                <h4 class="mt-4">7. Limitation of Liability</h4>
                <p class="text-cig-muted">
                    To the fullest extent permitted by law, Cornerstone Investment Group is not liable for any
                    indirect or consequential damages arising from your use of this website.
                </p>

                <h4 class="mt-4">8. Contact Us</h4>
                <p class="text-cig-muted mb-0">
                    Questions about these terms? Email
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
