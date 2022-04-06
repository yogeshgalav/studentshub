<!DOCTYPE html>
<html lang="en">

<head>

    @include('includes.meta')
    @include('includes.title')
    @yield('compiledJs')
    <script src="{{ asset('js/vue.js') }}" defer></script>
    <script src="{{ asset('js/manifest.js') }}" defer></script>
    <link href="{{ asset('css/app.css') }}" type="text/css" rel="stylesheet">
    @include('includes.fonts')
    <!-- <script src="/js/lang.js"></script> -->
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('favicon1.ico')}}" />
</head>

<body>
    <div id="app">
        <main class="flex-center full-height">
            <div class="header">
                @include('includes.navbar')
            </div>



            <div class="main-area">
                <div class="sidebar-section" id="sidebar-section">
                    @include('includes.sidebar')
                </div>


                <div class="content">
                    @yield('content')
                </div>
            </div>



        </main>
    </div>
    @include('includes.jsVariables')
</body>

</html>