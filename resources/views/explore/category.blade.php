@extends('explore.app')
@section('content')
<router-view :categoryId="{{ json_encode($categoryId) }}"></router-view>
@endsection
