<!DOCTYPE html>
<html class="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="application-name" content="StudentsHUB"/>
    <meta name="author" content="Yogesh Galav"/>
    @if(isset($meta_description) && is_string($meta_description))
    <meta name="description" content="{{ $meta_description }}"/>
    @else
    <meta name="description" content="Student's Hub is a Social Network of Students where they can explore knowledge and find thier interest field."/>
    @endif
    @if(isset($meta_keywords) && is_string($meta_keywords))
    <meta name="keywords" content="{{ $meta_keywords }}"/>
    @else
    <meta name="keywords" content="studentshub, studenthub, students hub, student hub, sthub, studenthub.in, sthub.in"/>
    @endif

    <link rel="icon" href="{{ url('/public/favicon1.ico') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/all.min.js" async></script>
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet" media>
<!-- 
    <script src="https://polyfill.io/v3/polyfill.min.js?features=smoothscroll,NodeList.prototype.forEach,Promise,Object.values,Object.assign" defer></script>

    <script src="https://polyfill.io/v3/polyfill.min.js?features=String.prototype.startsWith" defer></script> -->

    <script src="{{ mix('/js/app.js') }}" defer></script>
    @if(env('APP_ENV')==='production')
    <!-- Hotjar Tracking Code for https://www.studentshub.in -->
    <script>
        (function(h,o,t,j,a,r){
            h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
            h._hjSettings={hjid:2980989,hjsv:6};
            a=o.getElementsByTagName('head')[0];
            r=o.createElement('script');r.async=1;
            r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
            a.appendChild(r);
        })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
    </script>
    @endif
</head>
<body class="">
    @inertia
</body>
</html>