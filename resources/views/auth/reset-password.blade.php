@extends('layouts.app')
@section('content')
<reset-password-component :token={{json_encode($token)}}></reset-password-component>
@endsection