<x-guest-layout>
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100 py-5">
            <div class="col-lg-6 col-md-8">

                <div class="auth-card bg-white overflow-hidden">
                    <div class="row g-0">
                        {{-- Brand strip --}}
                        <div class="col-12 text-center text-white py-4"
                             style="background: linear-gradient(135deg, #0D4EA3 0%, #2F5870 100%);">
                            <div class="bg-white d-inline-flex p-2 rounded-3 shadow-sm mb-2">
                                <img src="{{ asset('assets/images/cig-logo-whitebg.png') }}"
                                     alt="Cornerstone Investment Group" style="height:54px;">
                            </div>
                            <p class="mb-0 small" style="opacity:.85; letter-spacing:1px; font-family:var(--font-ui);">
                                BORROWER ACCOUNT REGISTRATION
                            </p>
                        </div>

                        <div class="col-12 p-4 p-md-5">
                            <div class="text-center mb-4">
                                <h4 class="fw-bold mb-1" style="font-size:1.8rem;">Create your account</h4>
                                <p class="text-cig-muted small mb-0">
                                    Register to apply for private funding with Cornerstone Investment Group.
                                </p>
                            </div>

                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label small fw-semibold text-cig-slate">Full Name</label>
                                    <input type="text" class="form-control form-control-lg fs-6" id="name" name="name"
                                        value="{{ old('name') }}" placeholder="Jane Doe" required autofocus>
                                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-danger small" />
                                </div>

                                <div class="mb-3">
                                    <label class="form-label small fw-semibold text-cig-slate">Email Address</label>
                                    <input type="email" class="form-control form-control-lg fs-6" id="email" name="email"
                                        value="{{ old('email') }}" placeholder="name@example.com" required>
                                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger small" />
                                </div>

                                <div class="row mb-4">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label class="form-label small fw-semibold text-cig-slate">Password</label>
                                        <input type="password" class="form-control form-control-lg fs-6" id="password"
                                            name="password" placeholder="Password" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label small fw-semibold text-cig-slate">Confirm Password</label>
                                        <input type="password" class="form-control form-control-lg fs-6"
                                            id="password_confirmation" name="password_confirmation"
                                            placeholder="Repeat password" required>
                                    </div>
                                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger small" />
                                </div>

                                <button type="submit" class="btn btn-cig btn-lg w-100">Create Account</button>
                            </form>

                            <hr class="my-4">
                            <div class="text-center">
                                <span class="small text-cig-muted">Already have an account?</span>
                                <a class="auth-link small" href="{{ route('login') }}">Log in</a>
                            </div>
                            <div class="text-center mt-2">
                                <a href="{{ route('home') }}" class="text-cig-muted small text-decoration-none">
                                    <i class="bi bi-arrow-left"></i> Back to Home
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-guest-layout>
