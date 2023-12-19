@section('title', 'Checkout |')

@section('content')
    <section>

        <div class="cartTitle">
            <h1>CHECKOUT</h1>
        </div>

        <form method=post action="/cart/checkout{{ $promotionCode ? '?promocode=' . $promotionCode->codigo : '' }}" class="checkoutForm">
            @csrf
            <div class="cartContent">
                <div class="tableWithCartProducts">
                    <div class="checkoutFormContent">

                        <div class="checkoutFieldsTitle">
                            <h2>Dados de entrega</h2>
                        </div>

                        <div class="checkoutFields">
                            <div class="inputBox">
                                <label for="firstName">Primeiro Nome:</label>
                                <input type="text" id="firstName" name="firstName" required>
                                @if ($errors->has('firstName'))
                                    <p class="text-danger">
                                        {{ $errors->first('firstName') }}
                                    </p>
                                @endif
                            </div>
                            <div class="inputBox">
                                <label for="lastName">Último Nome:</label>
                                <input type="text" id="lastName" name="lastName" required>
                                @if ($errors->has('lastName'))
                                    <p class="text-danger">
                                        {{ $errors->first('lastName') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="checkoutFields">
                            <div class="inputBox">
                                <label for="email">Email:</label>
                                <input type="email" id="email" name="email" required>
                                @if ($errors->has('email'))
                                    <p class="text-danger">
                                        {{ $errors->first('email') }}
                                    </p>
                                @endif
                            </div>
                            <div class="inputBox">
                                <label for="phone">Número de telemóvel:</label>
                                <input type="number" id="phone" name="phone" min="910000000" max="969999999">
                                @if ($errors->has('phone'))
                                    <p class="text-danger">
                                        {{ $errors->first('phone') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="checkoutFields">
                            <div class="inputBox">
                                <label for="street">Arruamento:</label>
                                <input type="text" id="street" name="street" required>
                            </div>
                        </div>
                        <div class="checkoutFields">
                            <div class="inputBox">
                                <label for="doorNo">Nº Porta:</label>
                                <input type="text" id="doorNo" name="doorNo" required>
                            </div>
                            <div class="inputBox">
                                <label for="floor">Andar (Caso exista):</label>
                                <input type="text" id="floor" name="floor">
                            </div>
                            <div class="inputBox">
                                <label for="postalCode">Código Postal:</label>
                                <input type="text" id="postalCode" name="postalCode" required>
                            </div>
                        </div>
                        <div class="checkoutFields">
                            <div class="inputBox">
                                <label for="city">Cidade:</label>
                                <input type="text" id="city" name="city" required>
                            </div>
                            <div class="inputBox">
                                <label for="country">País:</label>
                                <input type="text" id="country" name="country" value="Portugal" required>
                            </div>
                        </div>

                        <div class="checkoutFields">
                            <div class="inputBox">
                                <label for="nif">NIF:</label>
                                <input type="number" id="nif" name="nif" min="100000000" max="999999999" required>
                                @if ($errors->has('nif'))
                                    <p class="text-danger">
                                        {{ $errors->first('nif') }}
                                    </p>
                                @endif
                            </div>
                        </div>







                        <div class="paymentMethod">
                            <div class="paymentMethodTitle">
                                <h2>Método de Pagamento</h2>
                            </div>

                            <div class="paymentMethodSelect">
                                <div class="paymentMethodLabels">
                                    <input type="radio" id="radio-method-cash" name="paymentMethod" value="cash"
                                        required checked>
                                    <label for="radio-method-cash">
                                        <i class="fa-solid fa-money-bill-wave"></i> Dinheiro no ato de entrega
                                    </label>
                                </div>

                                <div class="paymentMethodLabels">
                                    <input type="radio" id="radio-method-card" name="paymentMethod" value="card"
                                        required>
                                    <label for="radio-method-card">
                                        <i class="fa-regular fa-credit-card"></i> Cartão bancário
                                    </label>
                                </div>

                                <div class="paymentMethodMbway">
                                    <input type="radio" id="radio-method-mbway" name="paymentMethod" value="mbway"
                                        required>
                                    <label for="radio-method-mbway">
                                        <img src="{{ asset('sources/payment/logoMbway.png') }}" alt="mbway"
                                            width="70px">
                                    </label>
                                </div>
                            </div>

                            <div id="method-card" style="display:none">

                                <div class="cardData">
                                    <h3>Dados do cartão</h3>
                                </div>


                                <div class="checkoutFields">
                                    <div class="inputBox">
                                        <label for="cardNo">Número do cartão:</label>
                                        <input type="number" id="cardNo" name="cardNo" min="3000000000000000" max="9999999999999999">
                                        @if ($errors->has('cardNo'))
                                            <p class="text-danger">
                                                {{ $errors->first('cardNo') }}
                                            </p>
                                        @endif
                                    </div>
                                    <div class="inputBox">
                                        <label for="cardHolder">Titular do cartão:</label>
                                        <input type="text" id="cardHolder" name="cardHolder">
                                    </div>
                                </div>


                                <div class="cardData">
                                    <h3>Validade do cartão</h3>
                                </div>

                                <div class="checkoutFields">
                                    <div class="inputBox">
                                        <label for="cardExpiryMonth">Mês:</label>
                                        <input type="number" id="cardExpiryMonth" name="cardExpiryMonth" min="1" max="12">
                                        @if ($errors->has('cardExpiryMonth'))
                                            <p class="text-danger">
                                                {{ $errors->first('cardExpiryMonth') }}
                                            </p>
                                        @endif
                                    </div>
                                    <div class="inputBox">
                                        <label for="cardExpiryYear">Ano:</label>
                                        <input type="number" id="cardExpiryYear" name="cardExpiryYear" min="23">
                                        @if ($errors->has('cardExpiryYear'))
                                            <p class="text-danger">
                                                {{ $errors->first('cardExpiryYear') }}
                                            </p>
                                        @endif
                                    </div>
                                    <div class="inputBox">
                                        <label for="cardCVV">CVV:</label>
                                        <input type="number" id="cardCVV" name="cardCVV" min="100" max="999">
                                        @if ($errors->has('cardCVV'))
                                            <p class="text-danger">
                                                {{ $errors->first('cardCVV') }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>


                            <div id="method-mbway" style="display:none">
                                <div class="checkoutFields">
                                    <div class="inputBox">
                                        <label for="mbwayNo">Número de telemóvel:</label>
                                        <input type="number" id="mbwayNo" name="mbwayNo" min="910000000"
                                            max="969999999">
                                        @if ($errors->has('mbway'))
                                            <p class="text-danger">
                                                {{ $errors->first('mbway') }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="extraInfo">
                                <div class="checkoutFields">
                                    <div class="inputBox">
                                        <label for="deliveryObs">Observações para a entrega (facultativo):</label>
                                        <textarea id="deliveryObs" name="deliveryObs"> </textarea>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
                <div class="orderSummary">
                    <div class="orderSummaryContent">
                        <div class="orderSummaryTitle">
                            <h2>Resumo</h2>
                        </div>
                        <div class="orderSummaryInfo">
                            <div class="orderSummaryInfoRow">
                                <p>Subtotal</p>
                                <p>{{ $subTotal }} €</p>
                            </div>
                            <div class="orderSummaryInfoRow">
                                <p>Envio</p>
                                <p>Grátis</p>
                            </div>
                            <div class="orderSummaryPromotionCode">
                                <div class="promoCodeApplied">
                                    <div class="promoCodeAppliedTitle">
                                        <p>Código de Promoção</p>
                                    </div>
                                    @if ($promotionCode != null)
                                        <div class="promoCodeAccepted">
                                            <div class="promoCodeDisplay">
                                                <div id="promoCodeActive">{{ $promotionCode->codigo }}</div>
                                                <p> <i class="fas fa-arrow-right"></i> </p>
                                                <div id="promoCodeDiscount">{{ $promotionCode->desconto * 100 }}%</div>
                                            </div>
                                            <div class="totalSaved">
                                                <p> - {{ $subTotal - $total }} €</p>
                                            </div>
                                        </div>
                                    @else
                                        <div class="promoCodeNotGiven">
                                            <p>Não tem código de promoção</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="orderSummaryTotal">
                        <p>Total</p>
                        <div class="orderSummaryTotalPrice">
                            <p> {{ $total }} €</p>
                        </div>
                    </div>
                    <div class="cartCheckoutButton">

                        <button type="submit">Confirmar encomenda</button>

                    </div>
                </div>
            </div>
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
