<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

@include('includes.meta')
@include('includes.title')

<script src="{{ asset('js/app.js') }}" defer></script>
    <link href="{{ asset('css/guest.css') }}" type="text/css" rel="stylesheet">
@include('includes.fonts')
<script src="/js/lang.js"></script>
<link rel="shortcut icon" type="image/x-icon" href="{{asset('favicon1.ico')}}" />
</head>
<body>
    <div id="app">
        <main class="flex-center position-ref full-height">   
<div class="main-header">
    @include('includes.logo-navbar')
</div>
<faq-component :faqs={{ $faq }} ></faq-component>
</main>
</div>
    @include('includes.jsVariables')
</body>
</html>