@extends('student-panel.app')
@section('content')
<daily-attempt-component :daily-questions="{{json_encode($daily_questions)}}"></daily-attempt-component>
@endsection