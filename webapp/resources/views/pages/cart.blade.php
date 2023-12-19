@section('title', 'Carrinho |')

@section('content')
    <section>

        <div class="cartTitle">
            <h1>CARRINHO</h1>
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
                            <?php $flag= true; ?>
                        @empty
                            <?php $flag= false; ?>    
                        @endforelse
                    </tbody>
                </table>

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
                            <div id ="promoCodeFormDiv">
                                <form id="promoCodeForm" action="{{ route('promo_codes.check') }}" method="post">
                                    @csrf
                                    <div class="promoCodeFormTitle">
                                        <label for="promotionCode">Código de Promoção</label>
                                    </div>
                                    <div class="promoCodeFormInput">
                                        <input type="text" name="promotionCode" id="promotionCode">
                                        <button type="submit" id="applyPromotionButton"><i class="fas fa-check"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div id="promoCodeApplied" class="d-none">
                                <div class="promoCodeApplied">
                                    <div class="promoCodeAppliedTitle">
                                        <p>Código de Promoção</p>
                                    </div>
                                    <div class="promoCodeAccepted">
                                        <div class="promoCodeDisplay">
                                            <div id="promoCodeActive"></div>
                                            <p>  <i class="fas fa-arrow-right"></i>  </p>
                                            <div id="promoCodeDiscount"></div>
                                        </div>
                                        <div class="promoCodeRemove" id="promoCodeRemove">
                                            <button id="removePromoCode">
                                                <i class="fas fa-xmark"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="orderSummaryTotal">
                    <p>Total</p>
                    <div class="orderSummaryTotalPrice">
                        <p id="totalPriceWithOutPromoCode" class="d-none">{{ $subTotal }}</p>
                        <p id="totalPrice">{{ $subTotal }}</p>
                        <p>€</p>
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

        <?php if($flag == false) { ?>
            <div class="cartEmpty">
                <div class="cartEmptyTitle">
                    <h2>O seu carrinho está vazio</h2>
                </div>
                <div class="cartEmptyButton">
                    <a href="/products"><button>Ir para a loja</button></a>
                </div>
            </div>
        <?php } else{ ?>

        <div class="cartSimilarProducts">
            <div class="cartSimilarProductsTitle">
                <h2>Produtos Semelhantes</h2>
            </div>
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

        <?php } ?>







    </section>
@endsection

@if (Auth::guard('admin')->check())
    @include('layouts.adminHeaderFooter')
@elseif (Auth::check())
    @include('layouts.userLoggedHeaderFooter')
@else
    @include('layouts.userNotLoggedHeaderFooter')
@endif
