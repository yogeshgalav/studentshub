@extends('student-panel.app')
@section('content')
<daily-attempt-component :daily-assignment="{{json_encode($daily_assignment)}}"></daily-attempt-component>
@endsection