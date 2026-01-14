<x-guest-layout>
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-5 col-lg-4">
                <div class="card border-0 shadow-lg rounded-4">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <i class="bi bi-shield-lock-fill text-primary-custom display-4"></i>
                            <h4 class="fw-bold mt-3">Secure Area</h4>
                            <p class="text-muted small">
                                This is a secure area of the application. Please confirm your password before continuing.
                            </p>
                        </div>

                        <form method="POST" action="{{ route('password.confirm') }}">
                            @csrf

                            <div class="form-floating mb-4">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required autofocus>
                                <label for="password">Current Password</label>
                                <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger small" />
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary-custom rounded-pill py-2 fw-bold">
                                    Confirm
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>