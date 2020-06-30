@extends('student-panel.app')
@section('content')
<unit-attempt-component :classroom-detail="{{json_encode($classroomDetail)}}"></unit-attempt-component>
@endsection