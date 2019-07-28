

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

@include('includes.meta')
@include('includes.title')
<script src="{{ asset('js/studentApp.js') }}" defer></script>
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
    <div id="studentApp">
        <main class="flex-center position-ref full-height">
            <div class="wrapper">
    <div class="main-header">
        @include('includes.logo-header')
        
        @include('includes.navbar')
    </div>

    @include('includes.sidebar')


    <div class="main-panel">
        <div class="content">
            <div class="page-inner">
                <div class="page-header">
                    <h4 class="page-title">Dashboard</h4>
                    <ul class="breadcrumbs">
                        <li class="nav-home">
                            <a href="#">
                                <i class="flaticon-home"></i>
                            </a>
                        </li>
                        <li class="separator">
                            <i class="flaticon-right-arrow"></i>
                        </li>
                        <li class="nav-item">
                            <a href="#">Pages</a>
                        </li>
                        <li class="separator">
                            <i class="flaticon-right-arrow"></i>
                        </li>
                        <li class="nav-item">
                            <a href="#">Starter Page</a>
                        </li>
                    </ul>
                </div>
                <div class="page-category">

                    @yield('content')
                </div>
            </div>
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
</body>
</html>
