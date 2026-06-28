@extends('user.layouts.app')

@section('title', 'Cornerstone Investment Group — Private Funding for Fix & Flip and Bridge Projects')

@push('head')
<style>
    /* ---------- HERO ---------- */
    .cig-hero {
        position: relative;
        background: linear-gradient(135deg, #0D4EA3 0%, #2F5870 100%);
        color: #fff;
        overflow: hidden;
    }
    .cig-hero::after {
        content: "";
        position: absolute;
        top: 0; right: 0;
        width: 46%;
        height: 100%;
        background: url('https://images.unsplash.com/photo-1560518883-ce09059eeffa?auto=format&fit=crop&w=1200&q=80') no-repeat center center/cover;
        opacity: .22;
        z-index: 0;
    }
    .cig-hero .container { position: relative; z-index: 1; }
    .cig-hero .hero-title {
        font-family: var(--font-display);
        font-weight: 700;
        font-size: clamp(2.5rem, 5vw, 4rem);
        line-height: 1.08;
        color: #fff;
        margin-bottom: 22px;
    }
    .cig-hero .hero-title .accent { color: var(--cig-light); }
    .cig-hero .hero-lead { font-size: 1.15rem; opacity: .9; max-width: 560px; line-height: 1.7; }
    .hero-badge {
        font-family: var(--font-ui);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-size: .72rem;
        background: rgba(255,255,255,.12);
        border: 1px solid rgba(255,255,255,.25);
        padding: 8px 18px;
        border-radius: 50px;
        display: inline-block;
        backdrop-filter: blur(4px);
    }
    .hero-stats .stat-num {
        font-family: var(--font-display);
        font-weight: 700;
        font-size: 2rem;
        color: var(--cig-light);
        line-height: 1;
    }
    .hero-stats .stat-label { font-family: var(--font-ui); font-size: .8rem; opacity: .8; }

    /* ---------- MISSION ---------- */
    .mission-band {
        background: var(--cig-slate);
        color: #fff;
        border-radius: 16px;
        padding: 40px 44px;
    }

    /* ---------- LOAN TYPE CARDS ---------- */
    .loan-card {
        background: #fff;
        border: 1px solid var(--cig-line);
        border-top: 4px solid var(--cig-blue);
        border-radius: 14px;
        padding: 34px 30px;
        height: 100%;
        transition: transform .25s ease, box-shadow .25s ease;
    }
    .loan-card:hover { transform: translateY(-6px); box-shadow: 0 18px 40px rgba(20,50,90,.10); }
    .loan-card .loan-icon {
        width: 60px; height: 60px;
        border-radius: 14px;
        background: var(--cig-light);
        color: var(--cig-dark);
        display: flex; align-items: center; justify-content: center;
        font-size: 1.7rem;
        margin-bottom: 20px;
    }

    /* ---------- PROCESS ---------- */
    .process-rail { position: relative; }
    .process-step .step-circle {
        width: 64px; height: 64px;
        border-radius: 50%;
        background: #fff;
        border: 2px solid var(--cig-light);
        color: var(--cig-dark);
        font-family: var(--font-display);
        font-weight: 700;
        font-size: 1.5rem;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 16px;
        position: relative;
        z-index: 2;
        transition: all .25s ease;
    }
    .process-step:hover .step-circle { background: var(--cig-dark); color: #fff; border-color: var(--cig-dark); }
    .process-step .step-label { font-family: var(--font-ui); font-weight: 600; color: var(--cig-slate); }
    @media (min-width: 992px) {
        .process-rail::before {
            content: "";
            position: absolute;
            top: 32px; left: 10%; right: 10%;
            height: 2px;
            background: var(--cig-light);
            z-index: 1;
        }
    }
</style>
@endpush

@section('content')

    {{-- ===================== HERO ===================== --}}
    <header class="cig-hero">
        <div class="container py-5">
            <div class="row align-items-center" style="min-height: 70vh;">
                <div class="col-lg-7 py-5">
                    <span class="hero-badge mb-4">Private Lending &nbsp;|&nbsp; Fix &amp; Flip + Bridge Loans</span>
                    <h1 class="hero-title mt-4">
                        Private Funding for <br>
                        <span class="accent">Fix &amp; Flip</span> and Bridge Projects
                    </h1>
                    <p class="hero-lead">
                        Friends-and-family private lending for real-estate-backed projects, with a
                        streamlined, relationship-based process for qualified borrowers.
                    </p>
                    <div class="d-flex flex-wrap gap-3 mt-4">
                        <a href="#apply" class="btn btn-cig-light btn-lg px-4">Apply for Funding</a>
                        <a href="#loan-types" class="btn btn-lg px-4 text-white"
                           style="border:2px solid rgba(255,255,255,.4);">Explore Loan Types</a>
                    </div>

                    <div class="hero-stats d-flex gap-5 mt-5 pt-2">
                        <div>
                            <div class="stat-num">Fix &amp; Flip</div>
                            <div class="stat-label">Renovation &amp; Purchase</div>
                        </div>
                        <div>
                            <div class="stat-num">Bridge</div>
                            <div class="stat-label">Short-Term Project Funding</div>
                        </div>
                        <div>
                            <div class="stat-num">5 Steps</div>
                            <div class="stat-label">Application to Closing</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    {{-- ===================== INTRO + MISSION ===================== --}}
    <section class="section-tight">
        <div class="container">
            <div class="row g-4 align-items-stretch">
                <div class="col-lg-6">
                    <div class="cig-card h-100 p-4 p-md-5">
                        <span class="eyebrow">Why Cornerstone</span>
                        <h2 class="mt-2 mb-3" style="font-size:1.9rem;">
                            Looking for private funding for your next real estate project?
                        </h2>
                        <p class="text-cig-muted mb-0" style="line-height:1.8;">
                            Cornerstone Investment Group provides friends-and-family private lending for
                            real-estate-backed projects. Our relationship-based approach keeps the process
                            clear and convenient for qualified borrowers — from your first application all
                            the way through to closing.
                        </p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mission-band h-100 d-flex flex-column justify-content-center">
                        <span class="eyebrow" style="color:var(--cig-light);">Our Mission</span>
                        <h3 class="text-white mt-2 mb-0" style="font-size:1.8rem; line-height:1.4;">
                            Help responsible borrowers move clearly from application to closing through
                            organized, tailored private lending.
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===================== LOAN TYPES ===================== --}}
    <section id="loan-types" class="section bg-cig-soft">
        <div class="container">
            <div class="text-center mb-5">
                <span class="eyebrow">What We Offer</span>
                <h2 class="mt-2" style="font-size:2.4rem;">Loan Types We Provide</h2>
                <p class="text-cig-muted">Flexible private capital structured around your project.</p>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="loan-card">
                        <div class="loan-icon"><i class="bi bi-hammer"></i></div>
                        <h4 class="mb-2" style="font-size:1.4rem;">Renovation Costs</h4>
                        <p class="text-cig-muted mb-0">
                            Fix-and-flip loans for rehab budgets and improvement expenses to bring your
                            property to its full potential.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="loan-card">
                        <div class="loan-icon"><i class="bi bi-house-add"></i></div>
                        <h4 class="mb-2" style="font-size:1.4rem;">Purchase Costs</h4>
                        <p class="text-cig-muted mb-0">
                            Fix-and-flip loans for property acquisition needs, helping you secure the
                            right opportunity at the right time.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="loan-card">
                        <div class="loan-icon"><i class="bi bi-arrow-left-right"></i></div>
                        <h4 class="mb-2" style="font-size:1.4rem;">Bridge Loans</h4>
                        <p class="text-cig-muted mb-0">
                            Real-estate bridge loans for short-term project needs, keeping your timeline
                            moving between transactions.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===================== PROCESS ===================== --}}
    <section id="process" class="section">
        <div class="container">
            <div class="text-center mb-5">
                <span class="eyebrow">How It Works</span>
                <h2 class="mt-2" style="font-size:2.4rem;">Our Process</h2>
                <p class="text-cig-muted">A clear, organized path from application to closing.</p>
            </div>

            <div class="row process-rail text-center g-4">
                @foreach([
                    ['n' => '1', 'label' => 'Application',   'desc' => 'Submit your borrower application.'],
                    ['n' => '2', 'label' => 'Documentation', 'desc' => 'Share supporting project details.'],
                    ['n' => '3', 'label' => 'Underwriting',  'desc' => 'We review and assess the deal.'],
                    ['n' => '4', 'label' => 'Approval',      'desc' => 'Terms are confirmed with you.'],
                    ['n' => '5', 'label' => 'Closing',       'desc' => 'Funds move toward your project.'],
                ] as $step)
                    <div class="col-lg col-md-4 col-6 process-step">
                        <div class="step-circle">{{ $step['n'] }}</div>
                        <h5 class="step-label mb-1" style="font-size:1.05rem;">{{ $step['label'] }}</h5>
                        <p class="small text-cig-muted mb-0">{{ $step['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ===================== APPLY / FORMS ===================== --}}
    <section id="apply" class="section bg-cig-cream">
        <div class="container">
            <div class="text-center mb-5">
                <span class="badge-cig mb-3">Apply Here</span>
                <h2 class="mt-2" style="font-size:2.4rem;">Request a Borrower Application</h2>
                <p class="text-cig-muted mx-auto" style="max-width:620px;">
                    Interested in being considered for funding? Complete an application below and our
                    team will review your project details.
                </p>
            </div>

            @auth
                @if(isset($dynamicForms) && count($dynamicForms) > 0)
                    @foreach ($dynamicForms as $form)
                        <div class="mb-5">
                            <x-dynamic-form :form="$form" />
                        </div>
                    @endforeach
                @else
                    <div class="cig-card text-center p-5 mx-auto" style="max-width:620px;">
                        <i class="bi bi-inbox text-cig-blue d-block mb-3" style="font-size:2.5rem;"></i>
                        <h4>No applications are open right now</h4>
                        <p class="text-cig-muted mb-0">Please check back soon — new funding programs are added regularly.</p>
                    </div>
                @endif
            @else
                <div class="cig-card text-center p-5 mx-auto" style="max-width:620px;">
                    <i class="bi bi-shield-lock text-cig-blue d-block mb-3" style="font-size:2.5rem;"></i>
                    <h4 class="mb-2">Create an account to apply</h4>
                    <p class="text-cig-muted mb-4">
                        Sign in or register a borrower account to access and submit our application forms securely.
                    </p>
                    <div class="d-flex flex-wrap gap-3 justify-content-center">
                        <a href="{{ route('register') }}" class="btn btn-cig px-4">Register &amp; Apply</a>
                        <a href="{{ route('login') }}" class="btn btn-cig-outline px-4">Login</a>
                    </div>
                </div>
            @endauth
        </div>
    </section>

@endsection
