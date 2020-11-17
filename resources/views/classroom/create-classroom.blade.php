@extends('classroom.app')
@section('content')
<create-classroom-component  :course-levels="{{json_encode($course_levels)}}"></create-classroom-component>
@endsection