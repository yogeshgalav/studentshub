@extends('layouts.classroom')
@section('compiledJs')
<script src="{{ asset('js/classroomApp.js') }}" defer></script>
<link href="{{ asset('css/classroomApp.css') }}" type="text/css" rel="stylesheet">
@endsection
@section('content')
@yield('content')
@endsection        