@extends('layouts.seeker')
@section('compiledJs')
<script src="{{ asset('js/seekerApp.js') }}" defer></script>
@endsection
@section('content')
@yield('content')
@endsection        