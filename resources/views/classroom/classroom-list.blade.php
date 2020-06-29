@extends('classroom.app')
@section('content')
<classroom-list-component :classroom-list="{{json_encode($classroomList)}}" :my-classrooms="{{json_encode($myClassrooms)}}" :teacher="{{json_encode($teacher)}}"></classroom-list-component>
@endsection