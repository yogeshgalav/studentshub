<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

@include('includes.meta')
@include('includes.title')
@yield('compiledJs')
@include('includes.fonts')
<script src="/js/lang.js"></script>
<link rel="shortcut icon" type="image/x-icon" href="{{asset('favicon1.ico')}}" />

    </head>
<body>
    <div id="instituteApp">
        <main class="flex-center position-ref full-height">
            <div class="wrapper">
    <div class="main-header">
    @include('includes.navbar')
    </div>
    
    <div class="container-fluid">
        <div class="row">
            <div class="width-250px mr-3">
                <div class="main-sidebar">
                @include('includes.sidebar')
                </div>
            </div>
            <div class="col-md-9">    
                <div class="content pt-100-px">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
</div>
</main>
</div>
    @include('includes.jsVariables')
<style>
.main-sidebar{
    padding-top:20px;
}
.font-size-18 {
    font-size :18px;
}
</style>
</body>
</html>
