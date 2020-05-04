@extends('layouts.student')
@section('compiledJs')
<script src="{{ asset('js/createPostApp.js') }}" defer></script>
<link href="{{ asset('css/createPostApp.css') }}" type="text/css" rel="stylesheet">
@endsection
@section('content')
@yield('content')
@endsection        