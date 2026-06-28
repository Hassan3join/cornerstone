<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cornerstone Investment Group — Account Access</title>

    @include('partials.brand-head')

    <style>
        body { background-color: #f3f8fe; }

        /* Shared auth form controls */
        .auth-card { border: 1px solid var(--cig-line); border-radius: 16px; box-shadow: 0 18px 50px rgba(20,50,90,.10); }
        .auth-brand img { height: 58px; width: auto; }
        .form-control { border-radius: 10px; }
        .form-control:focus {
            border-color: var(--cig-blue);
            box-shadow: 0 0 0 0.2rem rgba(90, 164, 237, 0.22);
        }
        .form-floating > label { color: var(--cig-muted); }
        .auth-link { color: var(--cig-dark); font-weight: 600; text-decoration: none; }
        .auth-link:hover { color: var(--cig-dark-2); text-decoration: underline; }
        .btn-cig.w-100, .btn-cig.btn-lg { width: 100%; }
    </style>
</head>

<body>
    <div class="font-sans antialiased">
        {{ $slot }}
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
