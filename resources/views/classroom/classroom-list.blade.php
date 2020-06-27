@extends('classroom.app')
@section('content')
<classroom-list-component :classroom-list="{{json_encode($classroomList)}}" :my-classrooms="{{json_encode($myClassrooms)}}"></classroom-list-component>
@endsection