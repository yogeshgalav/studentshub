@extends('student-panel.app')
@section('content')
<my-report-component :classrooms="{{ json_encode($classrooms) }}"></router-view>
@endsection