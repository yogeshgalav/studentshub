@extends('guest.app')
@section('content')
<router-view 
:srv-error401="{{ isset($srvError401) ? $srvError401 : 0 }}"
:srv-error-unknown="{{ isset($srvErrorUnknown) ? $srvErrorUnknown : 0 }}"
>
</router-view>
@endsection
