@extends('layouts.explore')
@section('compiledJs')
<script src="{{ asset('js/exploreApp.js') }}" defer></script>
<link href="{{ asset('css/exploreApp.css') }}" type="text/css" rel="stylesheet">
@endsection
@section('content')
@yield('content')
@endsection        