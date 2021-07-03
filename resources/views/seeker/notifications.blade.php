@extends('layouts.common-layout')
@section('compiledJs')
<script src="{{ asset('js/seekerApp.js') }}" defer></script>
@endsection
@section('content')
<router-view></router-view>
@endsection        