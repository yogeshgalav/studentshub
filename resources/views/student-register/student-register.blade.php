@extends('student-register.app')
@section('content')
<student-register :courses="{{ json_encode($courses) }}"></student-register> 
@endsection