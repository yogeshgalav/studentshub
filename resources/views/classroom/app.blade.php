@extends('layouts.auth-layout')
@section('compiledJs')
@if(Auth::user()->role_intended==='student')
<script src="{{ asset('js/studentPanelApp.js') }}" defer></script>
@else
<script src="{{ asset('js/classroomApp.js') }}" defer></script>
@endif
@endsection
@section('content')
@yield('content')
@endsection        