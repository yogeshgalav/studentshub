@extends('create-post.app')
@section('content')
<edit-post :post="{{ json_encode($post) }}"></edit-post>
@endsection
