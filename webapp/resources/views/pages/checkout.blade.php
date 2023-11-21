@section('content')
        <h1>Checkout</h1>
        <p>Total: {{ $total }} €</p>
        <form method=post action="/cart/checkout">
            @csrf
            <label for="cardNo">Número do cartão</label>
            <input type="number" id="cardNo" name="cardNo">
            <br>
            <label for="cardHolder">Titular do cartão</label>
            <input type="text" id="cardHolder" name="cardHolder">
            <br><br>
            Validade do cartão
            <br>
            <label for="cardExpiryMonth">Mês</label>
            <input type="number" id="cardExpiryMonth" name="cardExpiryMonth">
            <label for="cardExpiryYear">Ano</label>
            <input type="number" id="cardExpiryYear" name="cardExpiryYear">
            <br><br>
            <label for="cardCVV">CVV</label>
            <input type="number" id="cardCVV" name="cardCVV">
            <br><br><br>
            Morada de Entrega
            <br>
            <label for="street">Arruamento</label>
            <input type="text" id="street" name="street">
            <br>
            <label for="doorNo">Nº (e andar, se aplicável)</label>
            <input type="text" id="doorNo" name="doorNo">
            <br>
            <label for="cardNo">Cidade/Município</label>
            <input type="text" id="city" name="city">
            <br>
            <label for="country">País</label>
            <input type="text" id="country" name="country" value="Portugal">
            <br>
            <label for="deliveryObs">Observações para a entrega (facultativo)</label>
            <input type="textarea" id="deliveryObs" name="deliveryObs">
            <br><br>
            <button type="submit">Confirmar encomenda</button>
@endsection

@if (Auth::guard('admin')->check())
    @include('layouts.adminHeaderFooter')
@elseif (Auth::check())
    @include('layouts.userLoggedHeaderFooter')
@else
    @include('layouts.userNotLoggedHeaderFooter')
@endif

