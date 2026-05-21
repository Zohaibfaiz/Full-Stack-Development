<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MovieBooker') }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Force Dark Theme Defaults */
        body {
            background-color: #0f0f0f !important;
            color: #ffffff !important;
            font-family: 'Outfit', sans-serif;
        }
        
        .auth-card {
            background-color: #1a1a1a;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        /* Input Styling Override */
        .form-input {
            background-color: #0f0f0f !important;
            border: 1px solid #333 !important;
            color: white !important;
        }
        .form-input:focus {
            border-color: #dc2626 !important; /* Red border on focus */
            box-shadow: 0 0 0 1px #dc2626 !important;
        }
    </style>
</head>
<body class="antialiased min-h-screen flex flex-col justify-center items-center">

    <div class="mb-8">
        <a href="/" class="text-4xl font-extrabold tracking-tight text-white no-underline">
            MOVIE<span class="text-red-600">BOOKER</span>
        </a>
    </div>

    <div class="w-full sm:max-w-md px-6 py-8 auth-card rounded-xl shadow-md overflow-hidden sm:rounded-lg">
        {{ $slot }}
    </div>

    <div class="mt-8 text-center text-sm text-gray-500">
        &copy; {{ date('Y') }} MovieBooker.
    </div>

</body>
</html>