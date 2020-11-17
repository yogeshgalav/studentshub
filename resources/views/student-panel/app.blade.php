@extends('layouts.student-panel')
@section('compiledJs')
<script src="{{ asset('js/studentPanelApp.js') }}" defer></script>
<link href="{{ asset('css/studentPanelApp.css') }}" type="text/css" rel="stylesheet">
@endsection
@section('content')
@yield('content')
@endsection        