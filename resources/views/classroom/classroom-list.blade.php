@extends('classroom.app')
@section('content')
<classroom-list-component :classroom-list="{{json_encode($classroomList)}}"></classroom-list-component>
@endsection