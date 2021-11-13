<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    @include('includes.meta')
    @include('includes.title')
    @yield('compiledJs')
    <script prefetch src="{{ asset('js/seekerApp.js') }}" defer></script>
    <script prefetch src="{{ asset('js/editor.js') }}" defer></script>
    <script src="{{ asset('js/vue.js') }}" defer></script>
    <script src="{{ asset('js/manifest.js') }}" defer></script>
    <link href="{{ asset('css/app.css') }}" type="text/css" rel="stylesheet">
    @include('includes.fonts')
    <!-- <script src="/js/lang.js"></script> -->
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('favicon1.ico')}}" />
</head>

<body>
    <div id="app">
        <main class="flex-center position-ref full-height">
            <div class="main-header">
                @include('includes.navbar')
            </div>

            @yield('content')
        </main>
    </div>
    @include('includes.jsVariables')
</body>

</html>