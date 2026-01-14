<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cornerstone Loan Services - Build Your Future</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            /* --- CONCEPT 1 PALETTE (Blue & Gold) --- */
            --brand-blue: #203247;
            --brand-gold: #D4A017;
            --brand-gold-hover: #b88b14;
            --brand-light: #f4f6f8;
            --text-dark: #1a1a1a;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #ffffff;
            color: var(--text-dark);
            overflow-x: hidden;
        }

       /* --- Navbar Styling --- */
        .navbar {
            background: #ffffff;
            padding: 15px 0; /* More padding for a taller navbar */
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            padding: 0;
            margin-right: 1rem;
        }
        
        /* FIX: Allow the logo container to be wider */
        .logo-icon {
            width: auto; 
            height: auto; /* Let the image dictate height up to a max */
            display: flex;
            align-items: center;
        }

        /* FIX: Make the image larger */
        .logo-icon img {
            height: 65px; /* Increased from 50px to 65px for readability */
            width: auto;
            object-fit: contain;
            /* This ensures it blends with the white navbar if the image is white */
            background-color: white; 
        }

        /* Adjust Nav Links to center with the larger logo */
        .navbar-nav .nav-link {
            line-height: 65px; /* Matches logo height to vertically center text */
            padding-top: 0;
            padding-bottom: 0;
        }
        
        /* Keep buttons centered */
        .navbar-nav .btn {
            margin-top: auto;
            margin-bottom: auto;
        }

        .nav-link:hover {
            color: var(--brand-gold) !important;
        }

        .btn-gold {
            background-color: var(--brand-gold);
            color: white;
            font-weight: 600;
            padding: 10px 25px;
            border-radius: 4px;
            border: none;
            transition: all 0.3s;
        }

        .btn-gold:hover {
            background-color: var(--brand-gold-hover);
            color: white;
            transform: translateY(-1px);
        }

        /* --- Hero Section --- */
        .hero-section {
            position: relative;
            background-color: var(--brand-blue);
            color: white;
            padding: 100px 0;
            overflow: hidden;
        }

        .hero-bg-image {
            position: absolute;
            top: 0;
            right: 0;
            width: 50%;
            height: 100%;
            /* Family/House Image */
            background: url('https://images.unsplash.com/photo-1560518883-ce09059eeffa?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80') no-repeat center center/cover;
            z-index: 0;
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 60%;
            height: 100%;
            background: linear-gradient(90deg, var(--brand-blue) 60%, rgba(32, 50, 71, 0.9) 80%, rgba(32, 50, 71, 0) 100%);
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 600px;
        }

        .hero-title {
            font-size: 3rem;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 20px;
        }

        .hero-text {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-bottom: 30px;
            font-weight: 300;
        }

        /* --- Services & Process --- */
        .services-section { padding: 80px 0; background-color: #fff; text-align: center; }
        .section-title { color: var(--brand-blue); font-weight: 700; margin-bottom: 50px; font-size: 2rem; }
        .service-card { padding: 20px; transition: transform 0.3s; }
        .service-icon { font-size: 3rem; color: var(--brand-blue); margin-bottom: 20px; }
        .service-title { font-weight: 700; color: var(--brand-gold); margin-bottom: 10px; font-size: 1.2rem; }

        .process-section { padding: 80px 0; background-color: var(--brand-light); text-align: center; }
        .process-step { position: relative; padding: 0 20px; }
        .process-icon-box { width: 80px; height: 80px; border: 2px solid var(--brand-gold); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px auto; color: var(--brand-gold); font-size: 2rem; background: white; }
        
        .process-arrow { display: none; }
        @media (min-width: 768px) {
            .process-arrow { display: block; position: absolute; top: 40px; right: -20px; font-size: 1.5rem; color: #ccc; }
        }

        /* --- Forms Wrapper --- */
        .forms-wrapper { padding: 60px 0; background: #fff; }
        .form-card-custom { border: 1px solid #eee; border-left: 5px solid var(--brand-gold); box-shadow: 0 5px 20px rgba(0,0,0,0.05); border-radius: 8px; padding: 30px; background: white; }

        /* --- Footer --- */
        footer { background-color: var(--brand-blue); color: white; padding: 60px 0 20px 0; }
        footer h5 { color: white; font-weight: 700; margin-bottom: 20px; }
        footer a { color: rgba(255,255,255,0.7); text-decoration: none; display: block; margin-bottom: 10px; }
        footer a:hover { color: var(--brand-gold); }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">

    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <div class="logo-icon">
                    <img src="{{ asset('assets/images/logo1.png') }}" alt="Cornerstone Loan Services">
                </div>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#services">Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="#how-it-works">How It Works</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">About</a></li>
                    
                    @auth
                        @if(Auth::user()->role === 'admin')
                            <li class="nav-item ms-2"><a href="{{ route('admin.dashboard') }}"
                                    class="btn btn-sm btn-outline-danger rounded-pill">Admin</a></li>
                        @endif
                        <li class="nav-item ms-2">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="btn btn-sm btn-outline-secondary">Logout</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item ms-3">
                            <a href="{{ route('register') }}" class="btn btn-gold">Apply Now</a>
                        </li>
                        <li class="nav-item ms-2">
                            <a href="{{ route('login') }}" class="nav-link">Login</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <header class="hero-section">
        <div class="hero-bg-image"></div>
        <div class="hero-overlay"></div>
        
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="hero-content">
                        <h1 class="hero-title">Build Your Future on a <br><span style="color: var(--brand-gold);">Solid Foundation.</span></h1>
                        <p class="hero-text">Fast, secure, and user-friendly loan solutions tailored to your specific needs. Start building your financial dreams today.</p>
                        <a href="{{ route('register') }}" class="btn btn-gold btn-lg px-5">Get Started</a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="flex-grow-1">
        
        <section id="services" class="services-section">
            <div class="container">
                <h2 class="section-title">Our Services</h2>
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <div class="service-card">
                            <i class="bi bi-cash-coin service-icon"></i>
                            <h4 class="service-title">Personal Loans</h4>
                            <p class="text-muted">Fast and secure personal loans with competitive rates tailored to your life goals.</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="service-card">
                            <i class="bi bi-briefcase service-icon"></i>
                            <h4 class="service-title">Business Loans</h4>
                            <p class="text-muted">Expand your business with our flexible financing options designed for growth.</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="service-card">
                            <i class="bi bi-house-door service-icon"></i>
                            <h4 class="service-title">Mortgage Loans</h4>
                            <p class="text-muted">Find your dream home with mortgage plans that offer stability and ease.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="how-it-works" class="process-section">
            <div class="container">
                <h2 class="section-title">How It Works</h2>
                <div class="row justify-content-center">
                    <div class="col-md-3 mb-4 process-step">
                        <div class="process-icon-box">
                            <i class="bi bi-file-earmark-text"></i>
                        </div>
                        <h5 class="fw-bold">1. Submit Form</h5>
                        <p class="small text-muted">Fill out our simple online application.</p>
                        <i class="bi bi-chevron-right process-arrow"></i>
                    </div>
                    <div class="col-md-3 mb-4 process-step">
                        <div class="process-icon-box">
                            <i class="bi bi-search"></i>
                        </div>
                        <h5 class="fw-bold">2. Quick Review</h5>
                        <p class="small text-muted">Our team reviews your details instantly.</p>
                        <i class="bi bi-chevron-right process-arrow"></i>
                    </div>
                    <div class="col-md-3 mb-4 process-step">
                        <div class="process-icon-box">
                            <i class="bi bi-wallet2"></i>
                        </div>
                        <h5 class="fw-bold">3. Receive Funds</h5>
                        <p class="small text-muted">Get approved and receive your funds.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="forms-wrapper bg-light">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center mb-4">
                        <h3 class="fw-bold" style="color: var(--brand-blue);">Start Your Application</h3>
                    </div>
                </div>

                @yield('content')

                @if(isset($dynamicForms) && count($dynamicForms) > 0)
                    @foreach ($dynamicForms as $form)
                        <div class="col-md-8 mx-auto mt-4">
                            <div class="form-card-custom">
                                <h4 class="mb-3 fw-bold">{{ $form->name ?? 'Loan Application' }}</h4>
                                <x-dynamic-form :form="$form" />
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center text-muted py-3">
                        <p>Please log in or register to view available loan applications.</p>
                    </div>
                @endif
            </div>
        </section>
    </main>

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="mb-3">
                       <h5 class="fw-bold">CORNERSTONE</h5>
                    </div>
                    <p class="small text-white-50">Providing a solid foundation for your financial needs through secure and fast loan services.</p>
                </div>
                <div class="col-md-2 mb-4">
                    <h5>Contact</h5>
                    <a href="#">Services</a>
                    <a href="#">About</a>
                </div>
                <div class="col-md-2 mb-4">
                    <h5>Links</h5>
                    <a href="#">Privacy</a>
                    <a href="#">Terms</a>
                </div>
                <div class="col-md-4 mb-4">
                    <h5>Subscribe</h5>
                    <form class="d-flex">
                        <input class="form-control me-2" type="email" placeholder="Your Email" style="border:none;">
                        <button class="btn btn-gold" type="submit">Go</button>
                    </form>
                </div>
            </div>
            <hr style="border-color: rgba(255,255,255,0.1);">
            <div class="text-center pt-2">
                <p class="mb-0 small text-white-50">© 2025 Cornerstone Loan Services. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>