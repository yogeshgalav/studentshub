@extends('explore.app')
@section('content')
<router-view :query="{{ json_encode($query) }}"></router-view>
@endsection