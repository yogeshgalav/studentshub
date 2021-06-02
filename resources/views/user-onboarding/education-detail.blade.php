@extends('user-onboarding.app')
@section('content')
<education-detail 
:course-levels="{{json_encode($course_levels)}}"  
:student-details="{{json_encode($student_details)}}"
:classroom-count="{{json_encode($classroom_count)}}"
></education-detail>
@endsection
