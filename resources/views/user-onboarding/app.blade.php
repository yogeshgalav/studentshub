@extends('layouts.common-layout')
@section('compiledJs')
<script src="{{ asset('js/studentRegisterApp.js') }}" defer></script>
@endsection
@section('content')
@yield('content')
@endsection        