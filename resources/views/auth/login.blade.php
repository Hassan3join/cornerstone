<x-guest-layout>
    <div class="container-fluid">
        <div class="row g-0 min-vh-100">

            {{-- Left brand panel --}}
            <div class="d-none d-md-flex col-md-5 col-lg-6 align-items-center justify-content-center text-white position-relative"
                 style="background: linear-gradient(135deg, #0D4EA3 0%, #2F5870 100%); overflow:hidden;">
                <div class="position-absolute top-0 end-0 rounded-circle"
                     style="width:280px;height:280px;background:rgba(255,255,255,.06);filter:blur(40px);transform:translate(30%,-30%);"></div>
                <div class="px-5 text-center position-relative" style="max-width:460px;">
                    <div class="bg-white d-inline-flex p-3 rounded-4 mb-4 shadow">
                        <img src="{{ asset('assets/images/cig-logo-whitebg.png') }}" alt="Cornerstone Investment Group" style="height:80px;">
                    </div>
                    <h2 class="text-white mb-3" style="font-size:2rem;">Private Funding for Fix &amp; Flip and Bridge Projects</h2>
                    <p style="opacity:.85; line-height:1.7;">
                        Sign in to access your borrower dashboard and continue your application from
                        application to closing.
                    </p>
                </div>
            </div>

            {{-- Right form panel --}}
            <div class="col-md-7 col-lg-6 d-flex align-items-center py-5 bg-white">
                <div class="container">
                    <div class="row">
                        <div class="col-md-10 col-lg-9 col-xl-8 mx-auto">

                            <a href="{{ route('home') }}" class="auth-link small d-inline-block mb-4">
                                <i class="bi bi-arrow-left"></i> Back to Home
                            </a>

                            <h3 class="fw-bold mb-1" style="font-size:2rem;">Welcome back</h3>
                            <p class="text-cig-muted mb-4">Please log in to access your borrower dashboard.</p>

                            <x-auth-session-status class="mb-4 text-success" :status="session('status')" />

                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control" id="email" name="email"
                                        placeholder="name@example.com" value="{{ old('email') }}" required autofocus>
                                    <label for="email">Email address</label>
                                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger small" />
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Password" required>
                                    <label for="password">Password</label>
                                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger small" />
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
                                        <label class="form-check-label small text-cig-muted" for="remember_me">Remember me</label>
                                    </div>
                                    @if (Route::has('password.request'))
                                        <a class="auth-link small" href="{{ route('password.request') }}">Forgot password?</a>
                                    @endif
                                </div>

                                <button class="btn btn-cig btn-lg w-100 mb-3" type="submit">Sign In</button>

                                <p class="text-center small text-cig-muted mb-0">
                                    Don't have an account?
                                    <a class="auth-link" href="{{ route('register') }}">Register now</a>
                                </p>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-guest-layout>
