<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('includes.title')
    <script src="{{ asset('js/app.js') }}" defer></script>
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
    <div id="app">
        <main class="flex-center position-ref full-height">
        @switch($AuthUserType)
            @case('guest')
                @include('layouts.guest')
            @break
            @case('staff')
                @include('layouts.staff')
            @break
            @case('student')
                @include('layouts.student')
            @break
            @case('teacher')
                @include('layouts.teacher')
            @break
            @case('institute')
                @include('layouts.institute')
                @break
            @default
                @include('layouts.blank')
                @break
        @endswitch
        </main>
    </div>

    <script>
        window.App ={!! json_encode([
            'AuthUser' => $AuthUser,
            'AuthUserType' => $AuthUserType,
            'signedIn' => is_null($AuthUser),
            'csrfToken' => csrf_token(),
            'baseUrl' => URL::to('/'),
            'fileUrl' => config('url.file_storage_url'),
            ]) !!}
    </script>
    @stack('scripts')

</body>
</html>
