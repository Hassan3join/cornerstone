<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-dark">
            {{-- @if(request()->routeIs('admin.dashboard')) Dashboard Overview --}}
            @if(request()->routeIs('admin.applicants')) Loan Applicants
            @elseif(request()->routeIs('admin.disbursed')) Disbursed Loans
            @elseif(request()->routeIs('admin.settings')) System Settings
            @elseif(request()->routeIs('admin.profile.index')) Admin Profile
            @endif
        </h3>
    </div>
    
    <div class="d-flex gap-3 align-items-center">
        <button class="btn btn-white bg-white shadow-sm border position-relative">
            <i class="bi bi-bell"></i>
            <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle"></span>
        </button>

        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width:35px; height:35px;">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="d-none d-sm-block">
                    <span class="fw-bold small text-dark d-block">{{ Auth::user()->name }}</span>
                    <span class="text-muted small d-block" style="font-size: 10px; margin-top: -3px;">Administrator</span>
                </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end text-small shadow" aria-labelledby="dropdownUser1">
                <li><a class="dropdown-item" href="{{ route('admin.profile.index') }}">Profile</a></li>
                <li><a class="dropdown-item" href="{{ route('admin.settings') }}">Settings</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="dropdown-item text-danger">Sign out</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>