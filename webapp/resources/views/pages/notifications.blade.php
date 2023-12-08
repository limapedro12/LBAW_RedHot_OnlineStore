@section('content')
<section>
    <div class="ppTous-container">
        <h1>Notificações</h1>
        <div class="notification-list">
        @foreach($notifications as $notification)
        <div class="notification-item-list" link_to_redirect = "{{ $notification->link }}">
            <p class="notification-timestamp">{{$notification->timestamp}}</p>
            <p class="notification-body">{{$notification->texto}}</p>
            <form action="{{ route('deleteNotification', ['user_id' => Auth::user()->id, 'notification_id' => $notification->id]) }}" method="post">
                @csrf
                <button type="submit" class="btn btn-danger">Apagar</button>
            </form>
            <br>
        </div>
        @endforeach
        </div>
    </div>
</section>
@endsection

@if (Auth::guard('admin')->check())
    @include('layouts.adminHeaderFooter')
@elseif (Auth::check())
    @include('layouts.userLoggedHeaderFooter')
@else
    @include('layouts.userNotLoggedHeaderFooter')
@endif
