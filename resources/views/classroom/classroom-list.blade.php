@extends('classroom.app')
@section('content')
<classroom-list-component :classroom-detail="{{json_encode($classroomDetail)}}"></classroom-list-component>
@endsection