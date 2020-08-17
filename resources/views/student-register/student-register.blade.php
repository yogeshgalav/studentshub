@extends('student-register.app')
@section('content')
<student-register :course-levels="{{json_encode($course_levels)}}"></student-register> 
@endsection