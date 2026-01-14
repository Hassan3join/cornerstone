<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EasyLoan - Authentication</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fc;
        }

        .text-primary-custom {
            color: #4e73df;
        }

        .bg-primary-custom {
            background-color: #4e73df;
        }

        .btn-primary-custom {
            background: #4e73df;
            border: none;
            padding: 10px 20px;
            font-weight: 500;
            transition: 0.3s;
        }

        .btn-primary-custom:hover {
            background: #224abe;
        }
    </style>
</head>

<body>
    <div class="font-sans antialiased">
        {{ $slot }}
    </div>
</body>

</html>