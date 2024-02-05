<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

  <!-- Owl Carousel  -->
  <link rel="stylesheet" href="{{ asset('assets/libs/owl.carousel/dist/assets/owl.carousel.min.css') }}">

  @yield('style')

  {{-- CSS --}}
  <link id="themeColors" rel="stylesheet" href="{{ asset('assets/css/style.min.css') }}" />
</head>

<body>

  @if (session('success'))
    <script>
      Swal.fire({
        icon: 'success',
        title: 'Sukses',
        text: '{{ session('success') }}',
      });
    </script>
  @endif

  @if (session('error'))
    <script>
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: '{{ session('error') }}',
      });
    </script>
  @endif

  @yield('content')

  {{-- Script --}}
  @yield('script')
  <!--  Import Js Files -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/libs/simplebar/dist/simplebar.min.js') }}"></script>
  <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
  <!--  core files -->
  <script src="{{ asset('assets/js/app.min.js') }}"></script>
  <script src="{{ asset('assets/js/app.init.js') }}"></script>
  <script src="{{ asset('assets/js/app-style-switcher.js') }}"></script>
  <script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>
  <script src="{{ asset('assets/js/custom.js') }}"></script>
  <!--  current page js files -->
  <script src="{{ asset('assets/libs/owl.carousel/dist/owl.carousel.min.js') }}"></script>
  <script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
  <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>
