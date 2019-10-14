@extends('seeker.app')
@section('content')
<router-view :login-status="{{ isset($loginStatus) ? '1' : '0'}}"></router-view>
@endsection