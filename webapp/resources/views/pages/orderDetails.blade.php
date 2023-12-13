@section('content')
    <section>
        <h1>Encomenda {{ $purchase->id }}</h1>
        <p>
            <span class="order{{ $purchase->id }}State">Estado: {{ $purchase->estado }}</span><br>
            <span>{{ $purchase->total }}€</span><br>
            <span>{{ $purchase->timestamp }}</span><br>
            <span>Envio: {{ $purchase->descricao }}</span>
        </p>
        <h2>Produtos</h2>
        <ul>
            @foreach ($quantPriceProducts as $quantPriceProduct)
                <li>
                    <a href="/products/{{ $quantPriceProduct[2]->id }}">{{ $quantPriceProduct[2]->nome }}</a>
                    <p>
                        <span>Quantidade: {{ $quantPriceProduct[0] }}</span><br>
                        <span>Preço unitário: {{ $quantPriceProduct[1] }}€</span><br>
                    </p>
                </li>
            @endforeach
        </ul>
        @if (
            $purchase->estado != 'Enviada' &&
                $purchase->estado != 'Entregue' &&
                $purchase->estado != 'Cancelada' &&
                Auth::check())
            <form method=post action="/users/{{ $purchase->id_utilizador }}/orders/{{ $purchase->id }}/cancel">
                @csrf
                <button type="submit">Cancelar encomenda</button>
            </form>
        @endif

        @if (Auth::guard('admin')->check())
            <form method=post action="/users/{{ $purchase->id_utilizador }}/orders/{{ $purchase->id }}/change_state">
                @csrf
                <label for="state">Mudar o estado da encomenda:</label>
                <select name="state" id="states" multiple>
                    @foreach ($remainingStates as $state)
                        <option value="{{ $state }}">{{ $state }}</option>
                    @endforeach
                </select>
                <button type="submit">Mudar estado</button>
            </form>
        @endif
    </section>
@endsection

@if (Auth::guard('admin')->check())
    @include('layouts.adminHeaderFooter')
@elseif (Auth::check())
    @include('layouts.userLoggedHeaderFooter')
@else
    @include('layouts.userNotLoggedHeaderFooter')
@endif
