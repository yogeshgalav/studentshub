
 
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

@include('includes.meta')
@include('includes.title')
@yield('compiledJs')
@include('includes.fonts')
<script src="/js/lang.js"></script>
<link rel="shortcut icon" type="image/png" href="{{asset('favicon.png')}}" />
</head>
<body>
    <div id="exploreApp">
        <main class="flex-center position-ref full-height">   
<div class="main-header">
    @if($AuthUser)
    @include('includes.navbar')
    @else
    @include('includes.guest-navbar')
    @endif
</div>

@yield('content')  
</main>
</div>
    @include('includes.jsVariables')
</body>
</html>