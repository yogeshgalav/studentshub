@extends('explore.app')
@section('content')
<router-view :subjectId="{{ json_encode($subjectId) }}"></router-view>
@endsection
