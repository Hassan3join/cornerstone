<x-guest-layout>
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100 py-5">
            <div class="col-md-6 col-lg-5 col-xl-4">
                <div class="auth-card bg-white">
                    <div class="card-body p-4 p-md-5">
                        <div class="text-center mb-4">
                            <div class="text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                 style="width:64px;height:64px;background:linear-gradient(135deg,#0D4EA3,#2F5870);">
                                <i class="bi bi-key-fill fs-3"></i>
                            </div>
                            <h4 class="fw-bold mb-1">Forgot password?</h4>
                            <p class="text-cig-muted small mb-0">
                                Enter your email and we'll send you a secure reset link.
                            </p>
                        </div>

                        <x-auth-session-status class="mb-4 text-success small" :status="session('status')" />

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <div class="form-floating mb-4">
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="name@example.com" value="{{ old('email') }}" required autofocus>
                                <label for="email">Email Address</label>
                                <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger small" />
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-cig py-2">Email Password Reset Link</button>
                                <a href="{{ route('login') }}" class="btn btn-cig-outline py-2">Back to Login</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
