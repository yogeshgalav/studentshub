@extends('profile.app')
@section('content')
<router-view :profile="{{ json_encode($profile) }}"></router-view>
@endsection