@extends('layouts.profile')
@section('compiledJs')
<script src="{{ asset('js/profileApp.js') }}" defer></script>
<link href="{{ asset('css/profileApp.css') }}" type="text/css" rel="stylesheet">
@endsection
@section('content')
@yield('content')
@endsection        