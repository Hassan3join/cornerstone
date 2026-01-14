<x-guest-layout>
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-5 col-lg-4">
                <div class="card border-0 shadow-lg rounded-4">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <div class="bg-primary-custom text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                <i class="bi bi-key-fill fs-3"></i>
                            </div>
                            <h4 class="fw-bold">Forgot Password?</h4>
                            <p class="text-muted small mb-0">
                                No worries! Just enter your email and we'll send you a reset link.
                            </p>
                        </div>

                        <x-auth-session-status class="mb-4 text-success small" :status="session('status')" />

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <div class="form-floating mb-4">
                                <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" value="{{ old('email') }}" required autofocus>
                                <label for="email">Email Address</label>
                                <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger small" />
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary-custom rounded-pill py-2 fw-bold">
                                    Email Password Reset Link
                                </button>
                                <a href="{{ route('login') }}" class="btn btn-light rounded-pill py-2 text-muted">
                                    Back to Login
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>