@section('title', 'Carrinho |')

@section('content')
    <section>

        <div class="cartTitle">
            <h1>O Teu Carrinho</h1>
        </div>

        <div class="cartContent">
            <div class="tableWithCartProducts">

                <table>
                    <thead>
                        <tr>
                            <th>Imagem</th>
                            <th>Produto</th>
                            <th>Desconto</th>
                            <th>Preço</th>
                            <th>Quantidade</th>
                            <th>Total</th>
                            <th>Remover</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($list as $elem)
                            @include ('partials.productOnCart', [
                                'quantidade' => $elem[0],
                                'product' => $elem[1],
                            ])
                        @empty
                            <p>Ainda não tem produtos no carrinho</p>
                        @endforelse
                    </tbody>
                </table>

            </div>
            <div class="orderSummary">
                <div class="orderSummaryContent">
                    <div class="orderSummaryTitle">
                        <h2>Resumo da Encomenda</h2>
                    </div>
                    <div class="orderSummaryInfo">
                        <div class="orderSummarySubtotal">
                            <p>Subtotal</p>
                            <p>{{ $subTotal }} €</p>
                        </div>
                        <div class="orderSummaryShipping">
                            <p>Envio</p>
                            <p>Grátis</p>
                        </div>
                        <div class="orderSummaryPromotionCode">
                            <form id="promoCodeForm" action="{{ route('promo_codes.check') }}" method="post">
                                @csrf
                                <p>Código de Promoção</p>
                                <input type="text" name="promotionCode" id="promotionCode">
                                <button type="submit" id="applyPromotionButton">Aplicar</button>
                            </form>
                            <div id="promoCodeActive"></div>
                            <div id="promoCodeDiscount"></div>
                            <div id="promoCodeRemove" class="d-none"><button id="removePromoCode"> <i
                                        class="fas fa-xmark"></i> </button> </div>
                        </div>
                    </div>
                    <div class="orderSummaryTotal">
                        <p>Total</p>
                        <p id="totalPriceWithOutPromoCode" class="d-none">{{ $subTotal }}</p>
                        <p id="totalPrice">{{ $subTotal }}</p>
                    </div>
                </div>
                <div class="cartCheckoutButton">
                    @if (count($list) > 0)
                        <a href="/cart/checkout" id="checkoutLink"><button>Checkout</button></a>
                    @endif
                </div>
                <div id="promoCodeResult"></div>
            </div>
        </div>

        <div class="cartSimilarProducts">
            <div class="productsPageProducts" id='listOfProducts'>
                @foreach ($similarProducts as $product)
                    <div class="productListItem">
                        <div class="productListItemImg">
                            <a href = "/products/{{ $product->id }}">
                                <img src="{{ $product->getProductImage() }}" alt="Imagem de {{ $product->nome }}"
                                    width="100px" height="100px">
                            </a>
                        </div>
                        <div class="productListItemTitle">
                            <a href = "/products/{{ $product->id }}">
                                <h3>
                                    {{ $product->nome }}
                                </h3>
                            </a>
                        </div>

                        <div class="productListItemBottom">
                            <div class="productListItemRating">
                                <div class="productListItemNumberOfReviews">
                                    <p> {{ $product->getProductNumberOfReviews() }} avaliações </p>
                                </div>
                                <div class="productListItemHearts">
                                    <p> {{ $product->getProductRating() }}/ 5 <i class="fa-solid fa-heart"></i> </p>
                                </div>
                            </div>
                            <div class="productListItemPrices">
                                @if ($product->desconto > 0)
                                    <div class="productListItemOldPrice">
                                        <p class="discount">
                                            {{ $product->desconto * 100 }}%
                                        </p>
                                        <p class="oldPrices">
                                            {{ $product->precoatual }}
                                        </p>
                                        <p class="euro">€</p>
                                    </div>
                                    <div class="productListItemNewPrice">
                                        <p class="newPrices">
                                            {{ round($discountFunction($product->precoatual, $product->desconto), 2) }}
                                            €
                                        </p>
                                    </div>
                                @else
                                    <div class="productListItemPrice">
                                        <p class="Price">
                                            {{ $product->precoatual }}€
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
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
