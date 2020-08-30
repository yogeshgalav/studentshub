@extends('layouts.institute')
@section('compiledJs')
<script src="{{ asset('js/instituteApp.js') }}" defer></script>
<link href="{{ asset('css/instituteApp.css') }}" type="text/css" rel="stylesheet">
@endsection
@section('content')
@yield('content')
@endsection        