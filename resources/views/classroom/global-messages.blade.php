@extends('classroom.app')
@section('content')
<router-view :classrooms="{{ json_encode($classrooms) }}"></router-view>
@endsection