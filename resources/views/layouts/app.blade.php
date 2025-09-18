<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Infantil') }}</title>
    <!-- Bootstrap CSS -->
    <link href="{{ asset('build/assets/css/styles.css')}}" rel="stylesheet">
    <link rel="icon" href="{{ asset('build/assets/img/favicon.webp') }}" type="image/x-icon">

    <script src="{{ asset('build/assets/js/jquery.min.js') }}"></script>
</head>
<body>
    <div class="min-vh-100 bg-secondary">
        @include('layouts.navigation')

        <!-- Page Content -->
        <main class="bg-lighter">
            {{ $slot }}
        </main>
    </div>

    <!-- Bootstrap JS -->
    <script src="{{ asset('build/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('build/assets/js/imask.js') }}" type="text/javascript"></script>
    <script>
        // Passa o nome da rota atual para o JavaScript
        let currentRoute = "{{ Route::currentRouteName() }}";
    </script>
    <script src="{{ asset('build/assets/js/scripts.js') }}"></script>
</body>
</html>
