<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Cornerstone Investment Group — Private Real Estate Lending')</title>
    <meta name="description"
        content="Cornerstone Investment Group provides private funding for Fix &amp; Flip and Bridge projects — a streamlined, relationship-based process for qualified real-estate borrowers.">

    @include('partials.brand-head')
    @stack('head')
</head>

<body class="d-flex flex-column min-vh-100">

    {{-- ===================== NAVBAR ===================== --}}
    <nav class="navbar navbar-expand-lg cig-navbar fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('assets/images/cig-logo.png') }}" alt="Cornerstone Investment Group">
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
                data-bs-target="#cigNav" aria-controls="cigNav" aria-expanded="false">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="cigNav">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                            href="{{ route('home') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#loan-types">Loan Types</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#process">Our Process</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#apply">Apply</a></li>

                    @auth
                        @if(Auth::user()->role === 'admin')
                            <li class="nav-item ms-lg-2 my-1">
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-cig-outline btn-sm">Admin Panel</a>
                            </li>
                        @endif
                        <li class="nav-item ms-lg-2 my-1">
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button class="btn btn-cig-outline btn-sm">Logout</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item ms-lg-3 my-1">
                            <a href="{{ route('login') }}" class="nav-link d-inline">Login</a>
                        </li>
                        <li class="nav-item ms-lg-2 my-1">
                            <a href="{{ route('register') }}" class="btn btn-cig btn-sm px-4">Apply Now</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    {{-- spacer for fixed navbar --}}
    <div style="height: 76px;"></div>

    {{-- ===================== FLASH MESSAGES ===================== --}}
    @if(session('success') || session('error'))
        <div class="container mt-3">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-3" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show shadow-sm rounded-3" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
    @endif

    <main class="flex-grow-1">
        @yield('content')
    </main>

    {{-- ===================== FOOTER ===================== --}}
    <footer class="cig-footer mt-auto pt-5 pb-4">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="footer-icon mb-3">
                        <img src="{{ asset('assets/images/cig-logo-whitebg.png') }}" alt="Cornerstone Investment Group">
                    </div>
                    <p class="mb-0 pe-lg-4" style="opacity:.8;">
                        Private funding for Fix &amp; Flip and Bridge projects. A streamlined,
                        relationship-based process for qualified real-estate borrowers.
                    </p>
                </div>

                <div class="col-lg-2 col-6">
                    <h6>Company</h6>
                    <a href="{{ route('home') }}">Home</a>
                    <a href="{{ route('home') }}#loan-types">Loan Types</a>
                    <a href="{{ route('home') }}#process">Our Process</a>
                </div>

                <div class="col-lg-2 col-6">
                    <h6>Get Started</h6>
                    <a href="{{ route('home') }}#apply">Apply Now</a>
                    <a href="{{ route('login') }}">Login</a>
                    <a href="{{ route('register') }}">Register</a>
                </div>

                <div class="col-lg-2 col-6">
                    <h6>Legal</h6>
                    <a href="{{ route('privacy') }}">Privacy Policy</a>
                    <a href="{{ route('terms') }}">Terms of Use</a>
                </div>

                <div class="col-lg-2 col-6">
                    <h6>Contact</h6>
                    <a href="mailto:info@cornerstoneinvestmentgroup.com">
                        <i class="bi bi-envelope me-1"></i> Email Us
                    </a>
                    <div class="mt-2 fs-5">
                        <i class="bi bi-facebook me-2"></i>
                        <i class="bi bi-linkedin me-2"></i>
                        <i class="bi bi-instagram"></i>
                    </div>
                </div>
            </div>

            <hr style="border-color: rgba(255,255,255,0.15); margin: 32px 0 18px;">

            <div class="row align-items-center">
                <div class="col-md-8">
                    <p class="small mb-2 mb-md-0" style="opacity:.6; line-height:1.6;">
                        Funding subject to underwriting, approval, collateral review, and final loan documents.
                        This website is not a commitment to lend. Terms and availability may vary.
                    </p>
                </div>
                <div class="col-md-4 text-md-end">
                    <p class="small mb-0" style="opacity:.7;">
                        &copy; {{ date('Y') }} Cornerstone Investment Group, LLC.
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>
