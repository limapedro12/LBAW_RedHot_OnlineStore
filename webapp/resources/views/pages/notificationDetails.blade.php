@section('content')
<section>
    <h1>Detalhes da Notifiacação<small>Nova</small></h1>
    <p>{{$notification->timestamp}}</p>
    <p>{{$notification->texto}}</p>
</section>
@endsection

@if (Auth::guard('admin')->check())
    @include('layouts.adminHeaderFooter')
@elseif (Auth::check())
    @include('layouts.userLoggedHeaderFooter')
@else
    @include('layouts.userNotLoggedHeaderFooter')
@endif

