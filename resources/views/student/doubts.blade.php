@extends('student.app')
@section('content')
<router-view :categories="{{ json_encode($categories) }}"></router-view>
@endsection
