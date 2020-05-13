
 
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

@include('includes.meta')
@include('includes.title')
<script src="{{ asset('js/studentRegisterApp.js') }}" defer></script>
<link href="{{ asset('css/studentRegisterApp.css') }}" type="text/css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

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
    <div id="studentRegisterApp">
        <main class="flex-center position-ref full-height">   
<div class="main-header">
     @include('includes.logo-navbar')
</div>

@yield('content')  
</main>
</div>
<script>
    window.App ={!! json_encode([
        'AuthUser' => $AuthUser,
        'AuthUserType' => 'student',
        'signedIn' => is_null($AuthUser),
        'csrfToken' => csrf_token(),
        'baseUrl' => URL::to('/'),
        'fileUrl' => config('url.file_storage_url'),
        ]) !!}
</script>
</body>
</html>