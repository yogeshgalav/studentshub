

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

@include('includes.meta')
@include('includes.title')
<script src="{{ asset('js/studentApp.js') }}" defer></script>
<link href="{{ asset('css/app.css') }}" type="text/css" rel="stylesheet">
<script src="/js/lang.js"></script>
<link rel="shortcut icon" type="image/x-icon" href="{{asset('favicon.ico')}}" />

    </head>
<body>
    <div id="studentApp">
        <main class="flex-center position-ref full-height">
            <div class="wrapper">
    <div class="main-header">
    @include('includes.guest-navbar')
    </div>
    <div class="main-sidebar">
    @include('includes.sidebar')
    </div>

    <div class="main-panel">
        <div class="content">
            @yield('content')
        </div>
    </div>
</div>
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
<style>
.main-sidebar{
    padding-top:20px;
}
</style>
</body>
</html>
