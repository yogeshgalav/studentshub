@extends('layouts.student-panel')
@section('compiledJs')
<script src="{{ asset('js/studentPanelApp.js') }}" defer></script>
@endsection
@section('content')
@yield('content')
@endsection        