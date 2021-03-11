@extends('guest.app')
@section('content')
<faq-component :faqs="{{ json_encode($faqs) }}" ></faq-component>
@endsection
