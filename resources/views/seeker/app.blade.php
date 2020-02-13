@extends('layouts.student')
@section('compiledJs')
<script src="{{ asset('js/seekerApp.js') }}" defer></script>
@endsection
@section('content')
@yield('content')
@endsection        