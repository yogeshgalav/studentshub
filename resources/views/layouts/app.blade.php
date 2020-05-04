
 
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

@include('includes.meta')
@include('includes.title')
@yield('compiledJs')
<link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
<script src="/js/lang.js"></script>
<link rel="shortcut icon" type="image/png" href="{{asset('favicon.png')}}" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/all.min.js"></script>
<style>
        body
            {
                background-color:#fff;
                font-family: 'Open Sans', ;
    
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