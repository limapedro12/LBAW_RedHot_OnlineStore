@section('content')

    <section>

        <div class="productDetailsBreadcrumb">
            <p><a href="{{ url('/') }}">Home</a> > <a href="{{ url('/products') }}">Produtos</a> > {{ $product->nome }}
            </p>
        </div>

        <div class="productDisplay">

            <div class="productLeft">
                <div class="productImage">
                    <img src="{{ $product->getProductImage() }}" alt="Imagem do produto">
                </div>
                <div class="productBottomLeft">
                    <div class="productAdminOptions">
                        @if (Auth::guard('admin')->check())
                            @csrf
                            <div class="productDelete">
                                <a href="{{ route('editProduct', ['id' => $product->id]) }}">Editar</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="productRight">
                <div class="productInfo">
                    <div class="productDetails">
                        <div class="productTitle">
                            <h2> {{ $product->nome }} </h2>
                            @if (Auth::guard('admin')->check())
                                <div class="productEdit">
                                    <a href='/products/{{ $product->id }}/delete' id='eliminarProduto'><i
                                            class="fas fa-trash-alt"></i> </a>
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
                                <a href="{{ route('reviews', ['id_product' => $product->id]) }}"
                                    productId="{{ $product->id }}" productName="{{ $product->nome }}">
                                    {{ $product->getProductNumberOfReviews() }} Avaliações
                                </a>
                            </div>
                        </div>

                        <div class="similarProducts">
                            <p> Produtos Semelhantes: </p>
                            <div class="similarProductsName">
                                @foreach ($product->getTwoSimilarProductsRandom($product->id) as $similarProduct)
                                    <div class="similarProductsName">
                                        <a
                                            href="{{ route('productsdetails', ['id' => $similarProduct->id]) }}">{{ $similarProduct->nome }}</a>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="productDescription">
                            <p> {{ $product->descricao }} </p>
                        </div>
                    </div>



                </div>



                <div class="productBottomRight">
                    <div class="productAddWishlist">
                        @if (Auth::check())
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
                                <div class="addToWishlist">
                                    <form method="GET" action="{{ route('listWishlist', ['id' => Auth::user()->id]) }}">
                                        @csrf
                                        <input type="submit" value="Já na Minha Wishlist">
                                    </form>
                                </div>
                            @endif
                        @endif
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
                            <div class = "productStockAndPrice">

                            @if (Auth::guard('admin')->check())
                                <div class="productStock">                               
                                    <p> Stock: {{ $product->stock }} </p>
                                </div>        
                            @else
                                <div class="productStock">
                                    @if ($product->stock > 0)
                                        <p> Produto Disponível </p>
                                    @else
                                        <p> Produto Indisponível: Sem Stock </p>
                                    @endif
                                </div>
                            @endif
                                
                                <div class="productNewPrice">
                                    <p class="newPrice">
                                        {{ round($discountFunction($product->precoatual, $product->desconto), 2) }} €
                                    </p>
                                </div>
                            </div>
                        @else
                            <div class = "productStockAndPrice">
                                <div class="productStock">
                                    @if ($product->stock > 0)
                                        <p> Produto Disponível </p>
                                    @else
                                        <p> Produto Indisponível: Sem Stock </p>
                                    @endif
                                </div>
                                <div class="productPrice">
                                    <p class="Price">
                                        {{ $product->precoatual }}€
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>




                    <div class="productAddCart">
                        @if ($product->stock > 0 && !Auth::guard('admin')->check())
                            <form action="/products/{{ $product->id }}/add_to_cart" method="POST" class="addToCart">
                                @csrf
                                <div class="productQuantity">
                                    <label for="quantidade"> Quantidade: </label>
                                    <input type="number" name="quantidade" id="quantidade" value="1" min="1"
                                        max="{{ $product->stock }}">
                                </div>
                                <div class="productAddToCart">
                                    <input type="submit" value="Adicionar ao carrinho">
                                </div>
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
