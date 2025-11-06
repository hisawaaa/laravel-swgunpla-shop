<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Tài khoản') - {{ config('app.name', 'SWGunpla') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    @vite(['resources/css/app.css'])

    @stack('styles')
</head>
<body class="font-sans antialiased d-flex flex-column min-vh-100 bg-light"> {{-- Nền xám nhạt --}}
    
    @include('partials._navbar')

    @hasSection ('header')
    <header class="bg-white shadow-sm border-bottom">
        <div class="container py-3">
            @yield('header') {{-- Tiêu đề trang con --}}
        </div>
    </header>
    @endif

    <main class="flex-grow-1 py-4">
        <div class="container">
            @include('partials._flash')
            
            @yield('content') {{-- Nội dung chính --}}
        </div>
    </main>

    @include('partials._footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>