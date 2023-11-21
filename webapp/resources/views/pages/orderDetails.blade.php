@section('content')
        <h1>Encomenda {{$purchase->id}}</h1>
        <p>
            <span>Estado: {{$purchase->estado}}</span><br>
            <span>{{$purchase->total}}€</span><br>
            <span>{{$purchase->timestamp}}</span><br>
            <span>Envio: {{$purchase->descricao}}</span>
        </p>
        <h2>Produtos</h2>
        <ul>
            @foreach($quantPriceProducts as $quantPriceProduct)
                <li>
                    <a href="/products/{{$quantPriceProduct[2]->id}}">{{$quantPriceProduct[2]->nome}}</a>
                    <p>
                        <span>Quantidade: {{$quantPriceProduct[0]}}</span><br>
                        <span>Preço unitário: {{$quantPriceProduct[1]}}€</span><br>
                    </p>
                </li>
            @endforeach
        </ul>
        @if ($purchase->estado == 'Pendente')
            <form method=post action="/users/{{$purchase->id_utilizador}}/orders/{{$purchase->id}}/cancel">
                @csrf
                <button type="submit">Cancelar encomenda</button>
            </form>
        @endif
@endsection

@if (Auth::check())
    @include('layouts.userLoggedHeaderFooter')
@elseif (!Auth::check())
    @include('layouts.userNotLoggedHeaderFooter')
@endif
