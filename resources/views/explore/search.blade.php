@extends('explore.app')
@section('content')
<router-view :search-query="{{ json_encode($searchQuery) }}"></router-view>
@endsection
