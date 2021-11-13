@extends('layouts.auth-layout')
@section('compiledJs')
<script src="{{ asset('js/createPostApp.js') }}" defer></script>
<script src="{{ asset('js/editor.js') }}" defer></script>
@endsection
@section('content')
@yield('content')
@endsection        