@extends('layouts.auth-layout')
@section('compiledJs')
<script src="{{ asset('js/instituteApp.js') }}" defer></script>
@endsection
@section('content')
@yield('content')
@endsection        