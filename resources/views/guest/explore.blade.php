@extends('guest.app')
@section('content')
<router-view :posts="{{ json_encode($posts) }}" :categories="{{ json_encode($categories) }}"></router-view>
@endsection