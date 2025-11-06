<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'SWGunpla Admin')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- Bootstrap 5 + Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet"> 
    {{-- CSS Admin tùy biến --}}
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet"> 
    @stack('styles') 
</head>
<body class="bg-light">
    <div class="d-lg-flex min-vh-100">
        {{-- Sidebar --}}
        <aside class="admin-sidebar bg-dark text-white p-3"> 
            @include('admin.partials._sidebar') 
        </aside>

        {{-- Main Content Area --}}
        <main class="admin-content flex-grow-1"> 
            {{-- Topbar --}}
            @include('admin.partials._topbar') 

            {{-- Page Content --}}
            <div class="container-fluid py-3"> 
                {{-- Breadcrumb (Optional) --}}
                @include('admin.partials._breadcrumb') 

                {{-- Flash Messages --}}
                @include('admin.partials._flash') 
                {{-- Dynamic Content --}}
                @yield('content') 
            </div>
        </main>
    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> 
    @stack('scripts') 
</body>
</html>