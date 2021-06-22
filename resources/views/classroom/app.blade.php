@extends('layouts.auth-layout')
@section('compiledJs')
<script src="{{ asset('js/classroomApp.js') }}" defer></script>
@endsection
@section('content')
@yield('content')
@endsection        