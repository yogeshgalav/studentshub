<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="{{ url('vendors/mdi/css/materialdesignicons.min.css') }}">
  <link rel="stylesheet" href="{{ url('vendors/base/vendor.bundle.base.css') }}">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <link rel="stylesheet" href="{{ url('vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="{{ url('css/style.css') }}">
  <!-- endinject -->
  <link rel="shortcut icon" href="{{ url('images/favicon.png') }}" />
    <!-- Scripts -->
   <!--  <script src="{{ asset('js/app.js') }}" defer></script> -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <meta charset="utf-8">
  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
<style>
    .adminheading{font-family:tahoma, Arial, Helvetica, sans-serif; font-size:13px; font-weight:bold; color:#FFFFFF; text-decoration:none;}
</style>
    <!-- Styles -->
  <!--   <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->
</head>
<body>
    <div class="container-scroller">
            @include('admin/header')
            @yield('content')
            @include('admin/footer')
       
    </div>
</body>
</html>
