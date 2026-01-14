<div class="sidebar">
    <div class="sidebar-brand">
        <i class="bi bi-bank2 me-2"></i> EasyLoan
    </div>

    <nav class="sidebar-menu">
        <div class="text-uppercase small fw-bold mb-2 ps-3 mt-2"
            style="font-size: 11px; letter-spacing: 1px; opacity: 0.6;">
            Overview
        </div>

        <a href="{{ route('admin.dashboard') }}"
            class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2-fill"></i> Dashboard
        </a>

        <div class="text-uppercase small fw-bold mb-2 ps-3 mt-4"
            style="font-size: 11px; letter-spacing: 1px; opacity: 0.6;">
            Loan Management
        </div>

        <a href="{{ route('admin.applicants') }}"
            class="sidebar-link {{ request()->routeIs('admin.applicants') ? 'active' : '' }}">
            <i class="bi bi-people-fill"></i> Loan Applicants
            <span class="badge bg-danger rounded-pill ms-auto" style="font-size: 10px;">New</span>
        </a>

        <a href="{{ route('admin.disbursed') }}"
            class="sidebar-link {{ request()->routeIs('admin.disbursed') ? 'active' : '' }}">
            <i class="bi bi-cash-stack"></i> Disbursed Loans
        </a>

        <a href="{{ route('admin.transactions.index') }}"
            class="sidebar-link {{ request()->routeIs('transactions.index') ? 'active' : '' }}">
            <i class="bi bi-currency-dollar me-2"></i> Transactions
        </a>

        <div class="text-uppercase small fw-bold mb-2 ps-3 mt-4"
            style="font-size: 11px; letter-spacing: 1px; opacity: 0.6;">
            Form Engine
        </div>

        <a href="{{ route('admin.questions.index') }}"
            class="sidebar-link {{ request()->routeIs('admin.questions*') ? 'active' : '' }}">
            <i class="bi bi-collection-fill"></i> Question Bank
        </a>

        <a href="{{ route('admin.forms.index') }}"
            class="sidebar-link {{ request()->routeIs('admin.forms*') ? 'active' : '' }}">
            <i class="bi bi-ui-checks"></i> Form Builder
        </a>

        <div class="text-uppercase small fw-bold mb-2 ps-3 mt-4"
            style="font-size: 11px; letter-spacing: 1px; opacity: 0.6;">
            System
        </div>

        <a href="{{ route('admin.settings') }}"
            class="sidebar-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
            <i class="bi bi-gear-fill"></i> Settings
        </a>

        <a href="{{ route('admin.profile.index') }}"
            class="sidebar-link {{ request()->routeIs('admin.profile.index') ? 'active' : '' }}">
            <i class="bi bi-person-circle"></i> My Profile
        </a>

        <a href="{{ route('home') }}" class="sidebar-link mt-5">
            <i class="bi bi-box-arrow-left"></i> Back to Website
        </a>
    </nav>
</div>