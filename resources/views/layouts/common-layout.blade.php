<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    @include('includes.meta')
    @include('includes.title')
    @yield('compiledJs')
    @include('includes.fonts')
    <!-- <script src="/js/lang.js"></script> -->
    <link href="{{ asset('css/app.css') }}" type="text/css" rel="stylesheet">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('favicon1.ico')}}" />

</head>

<body>
    <div id="app">
        <main class="flex-center full-height">
            <div class="header" style="margin-bottom:130px;">
                @include('includes.navbar')
            </div>

            <div class="main-area">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>

        </main>
    </div>
    @include('includes.jsVariables')
</body>

</html>