@extends('guest.app')
@section('content')
<router-view
:email-error="{{json_encode($errors->has('email') ? $errors->first('email') : '')}}"
>
</router-view>
@endsection
