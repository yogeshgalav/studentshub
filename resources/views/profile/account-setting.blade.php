@extends('profile.app')
@section('content')
<router-view :user="{{ json_encode($user) }}"></router-view>
@endsection