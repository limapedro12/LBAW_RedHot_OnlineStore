@section('content')
    <body>
        <h1>As Minhas Encomendas</h1>
        <ul>
            @foreach ($purchases as $purchase)
                @include ('partials.purchase', ['purchase' => $purchase, 'userId' => $userId])
            @endforeach
        </ul>
    </body>
@endsection

@if (Auth::guard('admin')->check())
    @include('layouts.adminHeaderFooter')
@elseif (Auth::check())
    @include('layouts.userLoggedHeaderFooter')
@else
    @include('layouts.userNotLoggedHeaderFooter')
@endif

