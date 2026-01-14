<x-guest-layout>
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-5 col-lg-4">
                <div class="card border-0 shadow-lg rounded-4">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <h4 class="fw-bold">Reset Password</h4>
                            <p class="text-muted small">Enter your new password below.</p>
                        </div>

                        <form method="POST" action="{{ route('password.store') }}">
                            @csrf

                            <input type="hidden" name="token" value="{{ $request->route('token') }}">

                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{ old('email', $request->email) }}" required autofocus>
                                <label for="email">Email Address</label>
                                <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger small" />
                            </div>

                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="password" name="password" placeholder="New Password" required>
                                <label for="password">New Password</label>
                                <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger small" />
                            </div>

                            <div class="form-floating mb-4">
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" required>
                                <label for="password_confirmation">Confirm Password</label>
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-danger small" />
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary-custom rounded-pill py-2 fw-bold">
                                    Reset Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>