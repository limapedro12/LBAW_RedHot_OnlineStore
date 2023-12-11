@section('content')

    <section>

        <div class="productDetailsBreadcrumb">
            <a href="{{ url('/') }}">Home</a> > <a href="{{ url('/products') }}">Produtos</a> > {{ $product->nome }}
        </div>

        <div class="productDisplay">
            <div class="productImage">
                <img style="height: 200px;" src="{{ $product->getProductImage() }}" alt="Imagem do produto">
            </div>
            <div class="productInfo">
                <div class="productDetails">
                    <div class="productTitle">
                        <h2> {{ $product->nome }} </h2>
                        @if (Auth::guard('admin')->check())
                            <div class="productEdit">
                                <a href="{{ route('editProduct', ['id' => $product->id]) }}"><i
                                        class="fa-solid fa-edit"></i></a>
                            </div>
                        @endif
                    </div>
                    <div class="productDetailCategory">
                        <h3>{{ $product->categoria }} </h3>
                    </div>
                    <div class="productRatingAndReviews">
                        <div class="productRating">

                            <p> {{ $product->getProductRating() }}/5 <i class="fa-solid fa-heart"></i></p>
                        </div>
                        <div class="productReviews">
                            <a href="{{ route('reviews', ['id_product' => $product->id]) }}" productId="{{ $product->id }}"
                                productName="{{ $product->nome }}"> {{ $product->getProductNumberOfReviews() }} Avaliações
                            </a>
                        </div>
                    </div>

                    <div class="similarProducts">
                        <p> Semelhantes: </p>
                        <div class="similarProductsName">
                            @foreach ($product->getTwoSimilarProductsRandom($product->id) as $similarProduct)
                                <a
                                    href="{{ route('productsdetails', ['id' => $similarProduct->id]) }}">{{ $similarProduct->nome }}</a>
                            @endforeach
                        </div>
                    </div>

                    <div class="productDescription">
                        <p> {{ $product->descricao }} </p>
                    </div>
                </div>



            </div>

            <div class="productBottomLeft">
                <div class="delete">
                    @if (Auth::guard('admin')->check())
                        @csrf
                        <input type="submit" id='editarProduto' value="Editar"
                            action='/products/{{ $product->id }}/edit'>
                        <input type="submit" id='alterarStockDoProduto' value="Alterar Stock"
                            action='/products/{{ $product->id }}/changeStock'>
                        <input type="submit" id='eliminarProduto' value="Eliminar"
                            action='/products/{{ $product->id }}/delete'>
                    @endif
                </div>
            </div>

            <div class="productBottomRight">
                <div class="productAddWishlist">
                    @unless (Auth::guard('admin')->check())
                        <?php
                        $productWishlist = App\Models\Wishlist::where('id_utilizador', Auth::user()->id)
                            ->where('id_produto', $product->id)
                            ->first();
                        ?>

                        @if ($productWishlist == null)
                            <div class="addToWishlist">
                                @if (Auth::check())
                                    <form method="POST"
                                        action="{{ route('addToWishlist', ['id' => Auth::user()->id, 'id_product' => $product->id]) }}">
                                        @csrf
                                        <input type="submit" value="Adicionar à Wishlist">
                                    </form>
                                @endif
                            </div>
                        @else
                            <div class="toWishlist">
                                <a href="{{ route('listWishlist', ['id' => Auth::user()->id]) }}"><button>Já na Minha
                                        Wishlist</button></a>
                            </div>
                        @endif
                    @endunless
                </div>

                <div class="productPrices">
                    @if ($product->desconto > 0)
                        <div class="productOldPrice">
                            <p class="discount">
                                {{ $product->desconto * 100 }}%
                            </p>
                            <p class="oldPrice">
                                {{ $product->precoatual }}
                            </p>
                            <p class="euro">€ </p>
                        </div>
                        <div class="productNewPrice">
                            <p class="newPrice">
                                {{ round($discountFunction($product->precoatual, $product->desconto), 2) }} €
                            </p>
                        </div>
                    @else
                        <div class="productPrice">
                            <p class="Price">
                                {{ $product->precoatual }}€
                            </p>
                        </div>
                    @endif
                </div>


                <div class="productStock">
                    <p> Stock: {{ $product->stock }} </p>
                </div>

                <div class="productAddCart">
                    @if ($product->stock > 0 && !Auth::guard('admin')->check())
                        <form action="/products/{{ $product->id }}/add_to_cart" method="POST">
                            @csrf
                            <label for="quantidade"> Quantidade: </label>
                            <input type="number" name="quantidade" id="quantidade" value="1" min="1"
                                max="{{ $product->stock }}">
                            <button type="submit"> Adicionar ao carrinho </button>
                        </form>
                    @endif
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
