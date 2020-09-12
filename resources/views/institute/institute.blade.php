@extends('institute.app')
@section('content')
<router-view :institute-id="{{$instituteId}}"></router-view>
@endsection