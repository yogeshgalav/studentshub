@extends('user-onboarding.app')
@section('content')
<education-detail :course-levels="{{json_encode($course_levels)}}"  :student-details="{{json_encode($student_details)}}"></education-detail>
@endsection
