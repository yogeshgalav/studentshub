
 
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

@include('includes.meta')
@include('includes.title')
<script src="{{ asset('js/app.js') }}" defer></script>
<link href="{{ asset('css/app.css') }}" type="text/css" rel="stylesheet">
<script src="/js/lang.js"></script>
<link rel="shortcut icon" type="image/x-icon" href="{{asset('favicon.ico')}}" />
<style>
        body
            {
                background-color:#fff
    
            }
        
        </style>
    </head>
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
</body>
</html>