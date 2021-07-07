@extends('student.app')
@section('content')
<router-view :course-id="{{$courseId}}"></router-view>
@endsection
