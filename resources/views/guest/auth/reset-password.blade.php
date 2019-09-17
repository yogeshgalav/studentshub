@extends('layouts.guest')
@section('content')
<reset-password-component :token={{json_encode($token)}}></reset-password-component>
@endsection