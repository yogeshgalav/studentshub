@extends('layouts.email-layout')

@section('content')
    <tr>
        <td>
            <p class="mt-3">{{__('notification.hi')}} {{$user}},</p>
            <p class="mt-3">
            @if($private_labelled)
                {{__('notification.SystemOwnerOnboardingNotification.private_labelled', ['client'=>$client])}}
            @else
                {{__('notification.SystemOwnerOnboardingNotification.message', ['client'=>$client])}}
            @endif
            </p>
            <a href="{{$login_url}}" style="text-align: center; font-size: 0.9rem; line-height: 5; padding: 15px 50px; letter-spacing: 0.1em; color:{{ $theme['accent_color_forground'] }}; background:{{ $theme['accent_color_background'] }}; text-transform: uppercase; text-decoration: none; border-radius: 5px; font-weight: bold;">
                {{__('notification.SystemOwnerOnboardingNotification.btnCreateAccount')}}
            </a>
            <p class="mt-3">
                {!! __('notification.contactUs') !!}
            </p>
        </td>
    </tr>
@endsection
