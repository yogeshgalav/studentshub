@extends('explore.app')
@section('content')
<search-component :search-query="{{ json_encode($searchQuery) }}"></search-component>
@endsection
