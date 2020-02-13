@extends('layouts.app')
@section('compiledJs')
<script src="{{ asset('js/app.js') }}" defer></script>
@endsection
@section('content')
@yield('content')
@endsection        