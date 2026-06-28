<x-guest-layout>
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100 py-5">
            <div class="col-md-6 col-lg-5 col-xl-4">
                <div class="auth-card bg-white">
                    <div class="card-body p-4 p-md-5">
                        <div class="text-center mb-4">
                            <div class="text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                 style="width:64px;height:64px;background:linear-gradient(135deg,#0D4EA3,#2F5870);">
                                <i class="bi bi-shield-lock-fill fs-3"></i>
                            </div>
                            <h4 class="fw-bold mb-1">Reset password</h4>
                            <p class="text-cig-muted small mb-0">Enter your new password below.</p>
                        </div>

                        <form method="POST" action="{{ route('password.store') }}">
                            @csrf

                            <input type="hidden" name="token" value="{{ $request->route('token') }}">

                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Email" value="{{ old('email', $request->email) }}" required autofocus>
                                <label for="email">Email Address</label>
                                <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger small" />
                            </div>

                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="New Password" required>
                                <label for="password">New Password</label>
                                <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger small" />
                            </div>

                            <div class="form-floating mb-4">
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation" placeholder="Confirm Password" required>
                                <label for="password_confirmation">Confirm Password</label>
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-danger small" />
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-cig py-2">Reset Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
