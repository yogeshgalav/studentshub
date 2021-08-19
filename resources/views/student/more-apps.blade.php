@extends('student.app')
@section('content')
<router-view :apps="{{ json_encode($apps) }}"></router-view>
@endsection
