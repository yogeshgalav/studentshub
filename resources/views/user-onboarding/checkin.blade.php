@extends('user-onboarding.app')
@section('content')
<check-in :course-levels="{{json_encode($course_levels)}}"  :student-details="{{json_encode($student_details)}}"></check-in>
@endsection
