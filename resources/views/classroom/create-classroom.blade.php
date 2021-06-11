@extends('classroom.app')
@section('content')
<create-classroom-component  
:institute-list="{{json_encode($institute_list)}}"
:course-levels="{{json_encode($course_levels)}}"
></create-classroom-component>
@endsection