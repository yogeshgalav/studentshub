@extends('student-panel.app')
@section('content')
<my-panel-component :classroom-detail="{{json_encode($classroomDetail)}}"></my-panel-component>
@endsection