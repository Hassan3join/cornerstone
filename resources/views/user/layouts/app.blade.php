<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EasyLoan - Fast Finance</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #858796;
            --accent-color: #36b9cc;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fc;
            overflow-x: hidden;
        }

        /* Glassy Navbar */
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.05);
            padding: 15px 0;
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--primary-color) !important;
            font-size: 1.5rem;
        }

        .nav-link {
            color: #5a5c69 !important;
            font-weight: 500;
            margin-right: 15px;
        }

        .nav-link:hover {
            color: var(--primary-color) !important;
        }

        .btn-primary-custom {
            background: linear-gradient(45deg, #4e73df, #224abe);
            border: none;
            color: white;
            padding: 10px 25px;
            border-radius: 50px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(78, 115, 223, 0.4);
            transition: all 0.3s;
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(78, 115, 223, 0.6);
            color: white;
        }

        footer {
            background: #2c3e50;
            color: white;
            padding: 40px 0;
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">

    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="bi bi-bank2 me-2"></i>EasyLoan
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Loan Plans</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">About Us</a></li>

                    @auth
                        @if(Auth::user()->role === 'admin')
                            <li class="nav-item"><a href="{{ route('admin.dashboard') }}"
                                    class="btn btn-sm btn-outline-danger ms-2 rounded-pill">Admin Panel</a></li>
                        @endif
                        <li class="nav-item ms-3">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="btn btn-outline-secondary rounded-pill btn-sm px-4">Logout</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item ms-2"><a href="{{ route('login') }}" class="nav-link">Login</a></li>
                        <li class="nav-item"><a href="{{ route('register') }}" class="btn btn-primary-custom ms-2">Get
                                Started</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div style="height: 80px;"></div>

    <main class="flex-grow-1">
        @yield('content')
    </main>

    <footer class="mt-auto">
        <div class="container text-center">
            <div class="mb-3">
                <i class="bi bi-facebook mx-2"></i>
                <i class="bi bi-twitter mx-2"></i>
                <i class="bi bi-instagram mx-2"></i>
            </div>
            <p class="mb-0 text-white-50">© 2025 EasyLoan Finance. Secure & Trusted.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>