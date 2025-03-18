<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <title>@yield('title')</title>

    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('src/fontawesome-free/css/all.min.css') }}">
    <!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
      integrity="sha256-9kPW/n5nn53j4WMRYAxe9c1rCY96Oogo/MKSVdKzPmI="
      crossorigin="anonymous"
    />
</head>
<body class="sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
        {{-- navbar --}}
        @include('includes.header')

        {{-- sidebar --}}
        @include('includes.sidebar')

        <main class="app-main">
            @yield('content')
        </main>
        
        @unless (
            request()->routeIs('sign-in.customer') ||
            request()->routeIs('sign-in.employee') ||
            request()->routeIs('sign-in.selection') ||
            request()->routeIs('sign-up'))
            @include('includes.footer')
        @endunless
    </div>
    
    <!-- Scripts -->
    <script src="{{ asset('src/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('src/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>
</html>