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
        @if ($purchase->estado == 'Pendente' && Auth::check())
            <form method=post action="/users/{{$purchase->id_utilizador}}/orders/{{$purchase->id}}/cancel">
                @csrf
                <button type="submit">Cancelar encomenda</button>
            </form>
        @endif

        @if(Auth::guard('admin')->check())
            <form method=post action="/users/{{$purchase->id_utilizador}}/orders/{{$purchase->id}}/change_state">
                @csrf
                <label for="state">Mudar o estado da encomenda:</label>
                <select name="state" id="states" multiple>
                    <option value="{{ $remainingStates[0] }}">{{ $remainingStates[0] }}</option>
                    <option value="{{ $remainingStates[1] }}">{{ $remainingStates[1] }}</option>
                    <option value="{{ $remainingStates[2] }}">{{ $remainingStates[2] }}</option>
                </select>
                <button type="submit">Mudar estado</button>
            </form>
        @endif
@endsection

@if (Auth::guard('admin')->check())
    @include('layouts.adminHeaderFooter')
@elseif (Auth::check())
    @include('layouts.userLoggedHeaderFooter')
@else
    @include('layouts.userNotLoggedHeaderFooter')
@endif

