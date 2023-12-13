@section('content')
    <section>

        <div class="wishlistHeader">
            <h1>Minha Wishlist</h1>
        </div>

        @if (count($wishlist) == 0)
            <div class="wishlistEmpty">
                <div class="wishlistEmptyImg">
                    <img src="{{ asset('sources/wishlist/empty-wishlist.png') }}" alt="Wishlist Vazia">
                </div>
                <div class="wishlistEmptyText">
                    <h2> A tua wishlist está vazia! </h2>
                </div>
                <div class="wishlistEmptyButton">
                    <a href="{{ url('/products') }}">Catálogo</a>
                </div>
            </div>
        @endif

        <div class="productsPageProducts" id='listOfProducts'>
            @foreach ($wishlist as $productWishlist)
                <?php
                $product = App\Models\Product::where('id', $productWishlist->id_produto)->first();
                ?>

                <div class="productListItem">
                    <div class="productListItemImg">
                        <a href = "/products/{{ $product->id }}">
                            <img src="{{ $product->getProductImage() }}" alt="Imagem de {{ $product->nome }}" width="100px"
                                height="100px">
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

                    <form method="POST"
                        action="{{ route('removeFromWishlist', ['id' => $productWishlist->id_utilizador, 'id_product' => $product->id]) }}"
                        class="removeFromWishlistForm">
                        @csrf
                        @if($product->desconto > 0)
                            <input type="submit" value="Remover da Wishlist" class="productAsDiscountWishlist">
                        @else
                            <input type="submit" value="Remover da Wishlist" class="productAsNoDiscountWishlist">
                        @endif
                    </form>
                </div>
            @endforeach
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
