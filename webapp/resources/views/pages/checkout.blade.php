@section('title', 'Checkout |')

@section('content')
    <section>
        <h1>Checkout</h1>
        <p>Total: {{ $total }} €</p>
        <form method=post action="/cart/checkout">
            @csrf
            <p>Por favor, escolha um método de pagamento:</p>
            <input type="radio" id="radio-method-cash" name="paymentMethod" value="cash" required checked>
            <label for="method-cash">Pagar em dinheiro no ato de entrega</label>
            <br>
            <input type="radio" id="radio-method-card" name="paymentMethod" value="card" required>
            <label for="method-card">Cartão bancário</label>
            <br>
            <input type="radio" id="radio-method-mbway" name="paymentMethod" value="mbway" required>
            <label for="method-mbway">MB WAY</label>
            <div id="method-card" style="display:none">
                <label for="cardNo">Número do cartão</label>
                <input type="number" id="cardNo" name="cardNo">
                @if ($errors->has('cardNo'))
                    <p class="text-danger">
                        {{ $errors->first('cardNo') }}
                    </p>
                @endif
                <br>
                <label for="cardHolder">Titular do cartão</label>
                <input type="text" id="cardHolder" name="cardHolder">
                <br><br>
                Validade do cartão
                <br>
                <label for="cardExpiryMonth">Mês</label>
                <input type="number" id="cardExpiryMonth" name="cardExpiryMonth">
                @if ($errors->has('cardExpiryMonth'))
                    <p class="text-danger">
                        {{ $errors->first('cardExpiryMonth') }}
                    </p>
                @endif
                <label for="cardExpiryYear">Ano</label>
                <input type="number" id="cardExpiryYear" name="cardExpiryYear">
                @if ($errors->has('cardExpiryYear'))
                    <p class="text-danger">
                        {{ $errors->first('cardExpiryYear') }}
                    </p>
                @endif
                <br><br>
                <label for="cardCVV">CVV</label>
                <input type="number" id="cardCVV" name="cardCVV">
                @if ($errors->has('cardCVV'))
                    <p class="text-danger">
                        {{ $errors->first('cardCVV') }}
                    </p>
                @endif
            </div>
            <div id="method-mbway" style="display:none">
                <label for="mbwayNo">Número de telemóvel</label>
                <input type="number" id="mbwayNo" name="mbwayNo" min="910000000" max="969999999">
                @if ($errors->has('mbway'))
                    <p class="text-danger">
                        {{ $errors->first('mbway') }}
                    </p>
                @endif
            </div>
            <br><br><br>
            Morada de Entrega
            <br>
            <label for="street">Arruamento</label>
            <input type="text" id="street" name="street" required>
            <br>
            <label for="doorNo">Nº (e andar, se aplicável)</label>
            <input type="text" id="doorNo" name="doorNo" required>
            <br>
            <label for="cardNo">Cidade/Município</label>
            <input type="text" id="city" name="city" required>
            <br>
            <label for="country">País</label>
            <input type="text" id="country" name="country" value="Portugal" required>
            <br>
            <label for="deliveryObs">Observações para a entrega (facultativo)</label>
            <input type="textarea" id="deliveryObs" name="deliveryObs">
            <br><br>
            <button type="submit">Confirmar encomenda</button>
        </form>
    </section>
@endsection

@if (Auth::guard('admin')->check())
    @include('layouts.adminHeaderFooter')
@elseif (Auth::check())
    @include('layouts.userLoggedHeaderFooter')
@else
    @include('layouts.userNotLoggedHeaderFooter')
@endif
