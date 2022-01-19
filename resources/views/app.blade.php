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
    <meta name="description" content="Student's Hub is the first and only Educational Social Network made for Students, Teachers and Institutes."/>
    @endif
    @if(isset($meta_keywords) && is_string($meta_keywords))
    <meta name="keywords" content="{{ $meta_keywords }}"/>
    @else
    <meta name="keywords" content="educational, social network, posts, interest field, subjects, school, classmates, doubts"/>
    @endif

    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/all.min.js" async></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" media>
<!-- 
    <script src="https://polyfill.io/v3/polyfill.min.js?features=smoothscroll,NodeList.prototype.forEach,Promise,Object.values,Object.assign" defer></script>

    <script src="https://polyfill.io/v3/polyfill.min.js?features=String.prototype.startsWith" defer></script> -->

    <script src="{{ mix('/js/app.js') }}" defer></script>
</head>
<body class="">
    @inertia
</body>
</html>