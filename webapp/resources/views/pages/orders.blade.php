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

@if (Auth::check())
    @include('layouts.userLoggedHeaderFooter')
@elseif (!Auth::check())
    @include('layouts.userNotLoggedHeaderFooter')
@endif
