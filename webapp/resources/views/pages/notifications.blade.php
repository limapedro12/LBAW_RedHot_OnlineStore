@section('title', 'Notificações |')

@section('content')
    <section>
        <div class="ppTous-container">
            <div class="notificationTitle">
                <h1>Notificações</h1>
            </div>
            <div class="notification-list">
                <ul>
                    @forelse($notifications as $notification)
                        <li>
                            <div class="notification-item-list" notification_id = "{{ $notification->id }}">
                                <div class="notification-clickable" link_to_redirect = "{{ $notification->link }}">
                                    <div class="notification-top">
                                        <div class="notification-timestamp">
                                            <h2><i class="fa-solid fa-caret-right"></i>  {{ $notification->timestamp }}</h2>
                                        </div>
                                        @if (!$notification->lida)
                                            <span class="new-notification"> Nova </span>
                                        @endif
                                    </div>
                                    <p class="notification-body">{{ $notification->texto }}</p>
                                </div>
                                <form action="{{ route('deleteNotification', ['notification_id' => $notification->id]) }}"
                                    method="delete">
                                    @csrf
                                    <button type="submit" class="delete-notification">Apagar</button>
                                </form>

                            </div>
                        </li>
                    @empty
                    <div class="notification-empty">
                        <i class="fa-solid fa-bell"></i>
                        <h2>Não tem notificações</h2>
                    </div>
                    @endforelse
                </ul>
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
