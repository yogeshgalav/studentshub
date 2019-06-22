@switch($AuthUserType)
        @case('staffPortal')
            <title>Actionable HQ</title>
            @break
        @case('consultantPortal')
            <title> Consultant Dashboard - Actionable Conversations</title>
            @break
        @case('tenantPortal')
            <title>{{$tenantName}} - Actionable Conversations</title>
            @break
@endswitch