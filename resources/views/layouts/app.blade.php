<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Dashboard - Vitam</title> 
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700">
    <link rel="stylesheet" href="/css/styles.min.css">
</head>
 
<body id="page-top">
    <div id="wrapper">
        @include('layouts.navbar-side')
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                @include('layouts.navbar')
                @yield('content')
            </div>
        @include('layouts.footer')
        </div>
        <a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>
    <script src="/js/jquery.min.js"></script>
    <script src="/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
    <script src="/js/script.min.js"></script>
    <script src="/js/app.js"></script>
    @stack('scripts')
    @if (session()->has('success'))
        <script>toastr.success("{{ session('success') }}")</script>
    @elseif (session()->has('info'))
        <script>toastr.info("{{ session('info') }}")</script>
    @elseif (session()->has('warning'))
        <script>toastr.warning("{{ session('warning') }}")</script>
    @elseif (session()->has('danger'))
        <script>toastr.error("{{ session('danger') }}")</script>
    @endif
    <script>
            $(document).ready(function(){
               $('.dropdown-toggle').dropdown()
           });
       </script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }});
    </script>
</body>

</html>