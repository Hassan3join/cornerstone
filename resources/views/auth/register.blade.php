<x-guest-layout>
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-lg-5 col-md-7">
                
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h4 class="fw-bold text-gray-900 mb-4">Create an Account!</h4>
                                        <p class="text-muted mb-4 small">Join EasyLoan today and get funded fast.</p>
                                    </div>
                                    
                                    <form method="POST" action="{{ route('register') }}">
                                        @csrf

                                        <div class="mb-3">
                                            <input type="text" class="form-control form-control-lg fs-6" id="name" name="name" placeholder="Full Name" required autofocus>
                                            <x-input-error :messages="$errors->get('name')" class="mt-2 text-danger small" />
                                        </div>

                                        <div class="mb-3">
                                            <input type="email" class="form-control form-control-lg fs-6" id="email" name="email" placeholder="Email Address" required>
                                            <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger small" />
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                                <input type="password" class="form-control form-control-lg fs-6" id="password" name="password" placeholder="Password" required>
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="password" class="form-control form-control-lg fs-6" id="password_confirmation" name="password_confirmation" placeholder="Repeat Password" required>
                                            </div>
                                            <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger small" />
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-primary-custom w-100 btn-lg rounded-pill fs-6">
                                            Register Account
                                        </button>
                                        
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small text-decoration-none" href="{{ route('login') }}">Already have an account? Login!</a>
                                    </div>
                                    <div class="text-center mt-2">
                                         <a href="{{ route('home') }}" class="text-decoration-none text-muted small"><i class="bi bi-arrow-left"></i> Home</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-guest-layout>