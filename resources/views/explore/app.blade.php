@extends('layouts.explore')
@section('compiledJs')
<script src="{{ asset('js/app.js') }}" defer></script>
<link href="{{ asset('css/guest.css') }}" type="text/css" rel="stylesheet">
@endsection
@section('content')
@yield('content')
@endsection
