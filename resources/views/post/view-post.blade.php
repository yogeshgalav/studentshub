@extends(Auth::check() ? 'layouts.student' : 'layouts.guest')
@section('content')
<router-view></router-view>
@endsection
