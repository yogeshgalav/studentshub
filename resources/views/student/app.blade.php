@extends('layouts.student')
@section('compiledJs')
<script src="{{ asset('js/studentApp.js') }}" defer></script>
<link href="{{ asset('css/studentApp.css') }}" type="text/css" rel="stylesheet">
@endsection
@section('content')
@yield('content')
@endsection        