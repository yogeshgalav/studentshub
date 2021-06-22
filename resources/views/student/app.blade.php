@extends('layouts.auth-layout')
@section('compiledJs')
<script src="{{ asset('js/studentApp.js') }}" defer></script>
@endsection
@section('content')
@yield('content')
@endsection        