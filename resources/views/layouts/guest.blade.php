
 
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
     @include('includes.guest-navbar')
</div>

@yield('content')  
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