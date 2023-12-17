<head>
    <title>Encomendas | RedHot</title>
</head>

@section('content')
    <section>
        <h1>As Minhas Encomendas</h1>
        <ul>
            @foreach ($purchases as $purchase)
                @include ('partials.purchase', ['purchase' => $purchase, 'userId' => $userId])
            @endforeach
        </ul>
    </section>
@endsection

@if (Auth::guard('admin')->check())
    @include('layouts.adminHeaderFooter')
@elseif (Auth::check())
    @include('layouts.userLoggedHeaderFooter')
@else
    @include('layouts.userNotLoggedHeaderFooter')
@endif
