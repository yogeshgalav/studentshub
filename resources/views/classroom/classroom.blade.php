@extends('classroom.app')
@section('content')
<classroom-component :classroom-detail="{{json_encode($classroomDetail)}}"></classroom-component>
@endsection