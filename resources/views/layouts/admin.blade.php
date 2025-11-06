<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'SWGunpla Admin')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    {{-- Bootstrap CSS & Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    @vite(['resources/css/app.css'])

    @stack('styles')
</head>
<body class="bg-light"> {{-- Nền xám nhạt --}}
    <div class="d-lg-flex min-vh-100">
        <aside class="admin-sidebar bg-dark text-white p-3">
            @include('admin.partials._sidebar') {{-- Gọi partial sidebar --}}
        </aside>

        <main class="admin-content flex-grow-1">
            @include('admin.partials._topbar')

            <div class="container-fluid py-3 px-4">
                @include('admin.partials._breadcrumb') 
                @include('partials._flash') 
                @yield('content') 
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>