@extends('layouts.seeker')
@section('compiledJs')
<script src="{{ asset('js/seekerApp.js') }}" defer></script>
<link href="{{ asset('css/seekerApp.css') }}" type="text/css" rel="stylesheet">
@endsection
@section('content')
@yield('content')
@endsection        