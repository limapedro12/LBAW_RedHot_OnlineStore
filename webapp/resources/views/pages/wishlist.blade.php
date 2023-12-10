@section('content')

    <section>

        <h1>Minha Wishlist</h1>

        @if (count($wishlist) == 0)
            <h3> A sua wishlist está vazia </h3>
            <p>Adicione os seus produtos favoritos!</p>
            <a href="/products"><button>Catalogo</button></a>
        @endif

        <div class="productsPageProducts" id='listOfProducts'>
            @foreach ($wishlist as $productWishlist)

                <?php
                    $product = App\Models\Product::where('id', $productWishlist->id_produto)->first();
                ?>

                <div class="productListItem">
                    <div class="productListItemImg">
                        <a href = "/products/{{ $product->id }}">
                            <img src="{{ $product->getProductImage() }}" alt="Imagem de {{ $product->nome }}" width="100px" height="100px">
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
                                <p> 723 {{ $product->avaliacao }} avaliações </p>
                            </div>
                            <div class="productListItemHearts">
                                <p> 4.3 {{ $product->avaliacao }}/ 5 <i class="fa-solid fa-heart"></i> </p>
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
                            @else
                                <div class="productListItemPrice">
                                    <p class="Price">
                                        {{ $product->precoatual }}€
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <form method="POST" action="{{ route('removeFromWishlist', ['id' => $productWishlist->id_utilizador, 'id_product' => $product->id]) }}" class="removeFromWishlistForm">
                        @csrf
                        <input type="submit" value="Remover da Wishlist">
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
