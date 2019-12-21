@extends('student-register.app')
@section('content')
<student-register :courses="{{ json_encode($courses) }}" :branches="{{ json_encode($branches) }}"></student-register> 
@endsection