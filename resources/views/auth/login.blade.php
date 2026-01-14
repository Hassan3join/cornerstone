<x-guest-layout>
    <div class="container-fluid ps-md-0">
        <div class="row g-0">
            
            <div class="d-none d-md-flex col-md-4 col-lg-6 bg-image"></div>

            <div class="col-md-8 col-lg-6">
                <div class="login d-flex align-items-center py-5">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-9 col-lg-8 mx-auto">
                                
                                <div class="mb-5">
                                    <a href="{{ route('home') }}" class="text-decoration-none text-muted small">
                                        <i class="bi bi-arrow-left"></i> Back to Home
                                    </a>
                                    <h3 class="login-heading mb-4 mt-3 fw-bold">Welcome back!</h3>
                                    <p class="text-muted">Please login to access your loan dashboard.</p>
                                </div>

                                <x-auth-session-status class="mb-4 text-success" :status="session('status')" />

                                <form method="POST" action="{{ route('login') }}">
                                    @csrf

                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required autofocus>
                                        <label for="email">Email address</label>
                                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger small" />
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                                        <label for="password">Password</label>
                                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger small" />
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
                                            <label class="form-check-label small" for="remember_me">Remember me</label>
                                        </div>
                                        @if (Route::has('password.request'))
                                            <a class="small text-muted" href="{{ route('password.request') }}">Forgot password?</a>
                                        @endif
                                    </div>

                                    <div class="d-grid">
                                        <button class="btn btn-lg btn-primary btn-primary-custom rounded-pill btn-login text-uppercase fw-bold mb-2" type="submit">Sign in</button>
                                    </div>
                                    
                                    <div class="text-center mt-3">
                                        <span class="small text-muted">Don't have an account?</span> 
                                        <a class="small fw-bold text-decoration-none" href="{{ route('register') }}">Register Now</a>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .login {
            min-height: 100vh;
        }
        .bg-image {
            background-image: url('https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80');
            background-size: cover;
            background-position: center;
        }
        .login-heading {
            font-weight: 300;
        }
        .form-floating:focus-within {
            z-index: 2;
        }
        .form-control:focus {
            border-color: #4e73df;
            box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.25);
        }
    </style>
</x-guest-layout>