
 
@include('includes.head')

<body>
    <div id="app">
        <main class="flex-center position-ref full-height">   
<div class="main-header">
    <div class="container-fluid">
   <div class="col-md-12">
               <!-- Logo Header -->
               <div class="logo-header">
                <a href="/" class="logo">
                    <img src="{{ asset('images/actionable.png') }}" alt="Actionable" class="navbar-brand">
                </a>
            </div>
            <!-- End Logo Header -->
            <!-- Navbar Header -->
            <div class="navbar navbar-header navbar-expand-lg">
            </div>
            <!-- End Navbar -->
   </div>
</div>
</div>

<div class="container">
@yield('content')  
</div>      
</main>
</div>
<script>
    window.App ={!! json_encode([
        'AuthUserType' => 'guest',
        'csrfToken' => csrf_token(),
        'baseUrl' => URL::to('/'),
        'fileUrl' => config('url.file_storage_url'),
        ]) !!}
</script>
@stack('scripts')

</body>
</html>