@extends('layouts.app')
@section('compiledJs')
<script src="{{ mix('js/app.js') }}" defer></script>
@endsection
@section('content')
@yield('content')
@endsection        