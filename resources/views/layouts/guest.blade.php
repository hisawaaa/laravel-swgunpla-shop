<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'SWGunpla'))</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    @vite(['resources/css/app.css']) {{-- Loads your custom styles --}}

    @stack('styles') {{-- For page-specific CSS --}}
</head>
<body class="font-sans antialiased d-flex flex-column min-vh-100 bg-white"> {{-- White background --}}
    
    @include('partials._navbar') {{-- Include Navbar --}}

    <div class="container mt-3">
         @include('partials._flash')
    </div>

    <main class="flex-grow-1">
        @yield('content') {{-- Page content goes here  --}}
    </main>

    @include('partials._footer') {{-- Include Footer --}}

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts') {{-- For page-specific JS --}}
</body>
</html>