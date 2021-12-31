@extends('explore.app')
@section('content')
<router-view :courseId="{{ json_encode($courseId) }}"></router-view>
@endsection
