@extends('student-register.app')
@section('content')
<student-register :course-levels="{{json_encode($course_levels)}}"  :student-details="{{json_encode($student_details)}}"></student-register> 
@endsection