@section('title', 'Encomenda ' . $purchase->id . ' |')

@section('content')
    <section>
        <div class="goBackButton">
            <div class="finalLinks">
                @if (Auth::guard('admin')->check())
                    <a href="/adminOrders"> <i class="fa-solid fa-arrow-left"></i> Voltar </a>
                @elseif (Auth::check())
                    <a href="/users/{{ Auth::user()->id }}"> <i class="fa-solid fa-arrow-left"></i> Voltar </a>
                @endif
            </div>
        </div>
        <div class="orderDetailTitle">
            <h1> Resumo de Encomenda </h1>
        </div>

        <div class="orderDetailInfo">
            <div class="orderDetailInfoContent">
                <div class="orderDetailInfoContentLeft">
                    <div class="orderDetailInfoContentLeftTitle">
                        <div class="orderTitle">
                            <h2>
                                <i class="fa-solid fa-cart-flatbed"></i> Encomenda
                                {{ $purchase->getNormalizeOrderId($purchase->id) }}
                            </h2>

                        </div>
                        <div class="orderDetailInfoContentLeftTitleState">
                            @if (Auth::guard('admin')->check())
                                <div class="orderChangeState">
                                    <form method=post
                                        action="/users/{{ $purchase->id_utilizador }}/orders/{{ $purchase->id }}/change_state">
                                        @csrf
                                        <label for="state">Mudar estado:</label>
                                        <select name="state" id="states">
                                            @foreach ($remainingStates as $state)
                                                <option value="{{ $state }}">{{ $state }}</option>
                                            @endforeach
                                        </select>
                                        <button type="submit"><i class="fa-solid fa-check"></i> </button>
                                    </form>
                                </div>
                            @else
                                <div class="orderState">
                                    <span class="order{{ $purchase->id }}State">{{ $purchase->estado }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="lineSeparator">
                        <div class="line"></div>
                    </div>
                    <div class="orderDetailInfoContentLeftInfo">
                        <div class="orderUserDetails">
                            <div class="orderUserDetailsTitle">
                                <p>{{ $purchase->timestamp }}</p>
                                <h3>Detalhes do Utilizador</h3>
                            </div>
                            <div class="orderUserDetailsContent">
                                <div class="userDataRow">
                                    <div class="userData">
                                        <label for="name">Nome:</label>
                                        <p>
                                            {{ $purchase->first_name }} {{ $purchase->last_name }}
                                        </p>
                                    </div>
                                    <div class="userData">
                                        <label for="email">Email:</label>
                                        <p>
                                            {{ $purchase->email }}
                                        </p>
                                    </div>
                                </div>
                                <div class="userDataRow">
                                    <div class="userData">
                                        <label for="address">Morada:</label>
                                        <p>
                                            {{ $purchase->morada }}, nº {{ $purchase->porta }} - {{ $purchase->andar }}
                                        </p>
                                    </div>
                                    <div class="userData">
                                        <label for="city">Cidade:</label>
                                        <p>
                                            {{ $purchase->localidade }}, {{ $purchase->codigo_postal }}
                                        </p>
                                    </div>
                                </div>

                                <div class="userDataRow">
                                    <div class="userData">
                                        <label for="phone">Telefone:</label>
                                        <p>
                                            {{ $purchase->phone }}
                                        </p>
                                    </div>
                                    <div class="userData">
                                        <label for="nif">NIF:</label>
                                        <p>
                                            {{ $purchase->nif }}
                                        </p>
                                    </div>
                                </div>
                                <div class="userDataRow">
                                    <div class="userObservations">
                                        <label for="observations">Observações:</label>
                                        <p>
                                            {{ $purchase->descricao }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="lineSeparator">
                        <div class="line"></div>
                    </div>
                    <div class="orderProductBought">
                        <div class="orderProductBoughtTitle">
                            <h3>Produtos Comprados</h3>
                        </div>
                        <div class="orderProductBoughtContent">
                            <div class="orderProductBoughtContentTable">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Imagem</th>
                                            <th>Produto</th>
                                            <th>Quantidade</th>
                                            <th>Preço</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($quantPriceProducts as $quantPriceProduct)
                                            <tr>
                                                <td>
                                                    @if ($quantPriceProduct[2]->deleted)
                                                        <div class="orderProductImg">
                                                            <img src="{{ asset('/products/default.png') }}"
                                                                alt="Imagem do produto" width="100px">
                                                        </div>
                                                    @else
                                                        <div class="orderProductImg">
                                                            <a href="/products/{{ $quantPriceProduct[2]->id }}">
                                                                <img src="{{ asset($quantPriceProduct[2]->getProductImage()) }}"
                                                                    alt="Imagem do produto" width="100px">
                                                            </a>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($quantPriceProduct[2]->deleted)
                                                        <div class="orderProductInfoName">
                                                            <p class="orderProductNameTable">{{ $quantPriceProduct[2]->nome }}</p>
                                                            <p>{{ $quantPriceProduct[2]->categoria }}</p>
                                                            <p>(Eliminado do catálogo)</p>
                                                        </div>
                                                    @else
                                                        <div class="orderProductInfoName">
                                                            <a href="/products/{{ $quantPriceProduct[2]->id }}">
                                                                {{ $quantPriceProduct[2]->nome }}
                                                            </a>
                                                            <p>{{ $quantPriceProduct[2]->categoria }}</p>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="orderProductInfo">
                                                        <p>{{ $quantPriceProduct[0] }}</p>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="orderProductInfo">
                                                        <p>{{ $quantPriceProduct[1] * $quantPriceProduct[0] }}€</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="orderSummary">
                    <div class="orderSummaryContent">
                        <div class="orderSummaryTitle">
                            <h2>Resumo </h2>
                            @if (Auth::guard('admin')->check())
                                <p>({{ $purchase->estado }})</p>
                            @endif
                        </div>
                        <div class="orderSummaryInfo">
                            <div class="orderSummaryInfoRow">
                                <p>Subtotal</p>
                                <p>{{ $purchase->sub_total }} €</p>
                            </div>
                            <div class="orderSummaryInfoRow">
                                <p>Envio</p>
                                <p>Grátis</p>
                            </div>
                            <div class="orderSummaryInfoRow">
                                <p>Pago com:</p>
                                <p>{{ $purchase->metodo_pagamento }}</p>
                            </div>
                            <div class="orderSummaryPromotionCode">
                                <div class="promoCodeApplied">
                                    <div class="promoCodeAppliedTitle">
                                        <p>Código de Promoção</p>
                                    </div>
                                    @if ($purchase->id_promo_code != null)
                                        <div class="promoCodeAccepted">
                                            <div class="promoCodeDisplay">
                                                <div id="promoCodeActive">
                                                    {{ $purchase->getPromotionCodeById($purchase->id_promo_code) }}
                                                </div>
                                                <p> <i class="fas fa-arrow-right"></i> </p>
                                                <div id="promoCodeDiscount">
                                                    {{ $purchase->getPromotionCodeDiscountById($purchase->id_promo_code) * 100 }}%
                                                </div>
                                            </div>
                                            <div class="totalSaved">
                                                <p> - {{ $purchase->sub_total - $purchase->total }} €</p>
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
                            <p> {{ $purchase->total }} €</p>
                        </div>
                    </div>
                    <div class="cartCheckoutButton">

                        @if (
                            $purchase->estado != 'Enviada' &&
                                $purchase->estado != 'Entregue' &&
                                $purchase->estado != 'Cancelada' &&
                                Auth::check())
                            <form method=post class="cancelOrder"
                                action="/users/{{ $purchase->id_utilizador }}/orders/{{ $purchase->id }}/cancel">
                                @csrf
                                <button type="submit">Cancelar encomenda</button>
                            </form>
                        @endif

                    </div>
                </div>

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
