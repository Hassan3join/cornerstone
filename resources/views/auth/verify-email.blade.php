<x-guest-layout>
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-6 col-lg-5">
                <div class="card border-0 shadow-lg rounded-4">
                    <div class="card-body p-5 text-center">
                        <div class="text-warning mb-3">
                            <i class="bi bi-envelope-paper-fill display-4"></i>
                        </div>
                        <h4 class="fw-bold">Verify Your Email</h4>
                        <p class="text-muted small mb-4">
                            Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you?
                        </p>

                        @if (session('status') == 'verification-link-sent')
                            <div class="alert alert-success small mb-4" role="alert">
                                <i class="bi bi-check-circle me-1"></i>
                                A new verification link has been sent to the email address you provided during registration.
                            </div>
                        @endif

                        <div class="d-grid gap-2">
                            <form method="POST" action="{{ route('verification.send') }}">
                                @csrf
                                <button type="submit" class="btn btn-primary-custom rounded-pill w-100 py-2 fw-bold">
                                    Resend Verification Email
                                </button>
                            </form>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-outline-secondary rounded-pill w-100 py-2">
                                    Log Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>