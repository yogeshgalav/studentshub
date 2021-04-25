@extends('layouts.email-layout')
@section('content')
    <tr>
        <td>
            <p class="mt-3">{{__('notification.hi')}},</p>
            <p>
                {{__('notification.forgotPassword.message_line_1')}}
            </p>
            <a href="{{$url}}"  style="text-align: center; font-size: 0.9rem; line-height: 5; padding: 15px 50px; letter-spacing: 0.1em; color:'#ffff'; background:'#10069f'; text-transform: uppercase; text-decoration: none; border-radius: 5px; font-weight: bold;">
                {{__('notification.forgotPassword.btnLabel')}}
            </a>
            <p class="mt-3">
                {!! __('notification.contactUs', ['helpdesk_email' => '<span class="text-primary">' . config('app.helpdesk_email') . '</span>']) !!}
            </p>
        </td>
    </tr>
@endsection
