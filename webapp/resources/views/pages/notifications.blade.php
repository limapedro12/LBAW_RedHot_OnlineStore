<head>
    <title>Notificações | RedHot</title>
</head>

@section('content')
    <section>
        <div class="ppTous-container">
            <h1>Notificações</h1>
            <br>
            <div class="notification-list">
                @forelse($notifications as $notification)
                    <div class="notification-item-list" notification_id = "{{ $notification->id }}">
                        <div class="notification-clickable" link_to_redirect = "{{ $notification->link }}">
                            <small class="notification-timestamp"> {{ $notification->timestamp }} </small>
                            @if (!$notification->lida)
                                <small class="new-notification"> Nova </small>
                            @endif
                            <p class="notification-body">{{ $notification->texto }}</p>
                        </div>
                        <form action="{{ route('deleteNotification', ['notification_id' => $notification->id]) }}"
                            method="delete">
                            @csrf
                            <button type="submit" class="delete-notification">Apagar</button>
                        </form>
                        <br>
                    </div>
                @empty
                    <p>Não tem notificações</p>
                @endforelse
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
