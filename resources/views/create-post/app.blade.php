@extends('layouts.auth-layout')
@section('compiledJs')
<script src="{{ asset('js/createPostApp.js') }}" defer></script>
@endsection
@section('content')
@yield('content')
@endsection        