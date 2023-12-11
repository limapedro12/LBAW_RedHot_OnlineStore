@section('content')

<section>

    <div class="productDetailsBreadcrumb">
        <a href="{{ url('/') }}">Home</a> > <a href="{{ url('/products') }}">Produtos</a> > {{ $product->nome }}
    </div>

    <div class="productDisplay">
        <div class="productImage">
            <img style="height: 200px;" src="{{ $product->getProductImage() }}" alt="Imagem do produto">
        </div>
        <div class="productDetails">
            <div class="productTitle">
                <h2> {{ $product->nome }} </h2>
            </div>
            <div class="productDetailCategory">
                <h3>{{ $product->categoria }} </h3>
            </div>
            <div class="productRatingAndReviews">
                <div class="productRating">
                    
                    <p> {{ $product->getProductRating() }}/5 <i class="fa-solid fa-heart"></i></p>
                </div>
                <div class="productReviews">
                    <p> {{ $product->getProductNumberOfReviews() }} Avaliações </p>
                </div>
            </div>




            <div class="similarProducts">
                <p> Produtos semelhantes: </p>
                <div class="similarProductsName">
                    @foreach ($product->getTwoSimilarProductsRandom($product->id) as $similarProduct)
                        <a href="{{ route('productsdetails', ['id' => $similarProduct->id]) }}">{{ $similarProduct->nome }}</a>
                    @endforeach
                </div>
            </div>



    </div>





















    <img style="height: 200px;" src="{{ $product->getProductImage() }}" alt="Imagem do produto">
    <section class="productDetails">
        <h2> {{ $product->nome }} </h2> 
        <p> 
            @if($product->desconto > 0)
                <span style = "text-decoration: line-through;">
                    {{ $product->precoatual }}
                </span>&nbsp
            @endif
            {{ round($discountFunction($product->precoatual, $product->desconto), 2) }} €
        </p>
        @if($product->desconto > 0)
            <p> Desconto: {{ $product->desconto * 100 }}% </p>
            <br>
        @endif
        <p> Categoria: {{ $product->categoria }} </p>
        <p> Stock: {{ $product->stock }} </p>
        <p> Descrição: </p>
        <p> {{ $product->descricao }} </p>
    </section>

    @if ($product->stock > 0 && !(Auth::guard('admin')->check()))
        <form action="/products/{{$product->id}}/add_to_cart" method="POST">
            @csrf
            <label for="quantidade"> Quantidade: </label>
            <input type="number" name="quantidade" id="quantidade" value="1" min="1" max="{{ $product->stock }}">
            <button type="submit"> Adicionar ao carrinho </button>
        </form>
    @endif

    @unless (Auth::guard('admin')->check())
    <?php 
        $productWishlist = App\Models\Wishlist::where('id_utilizador', Auth::user()->id)->where('id_produto', $product->id)->first();
    ?>

    @if($productWishlist == null)
        <section class="addToWishlist">
            @if (Auth::check())
                <form method="POST" action="{{ route('addToWishlist', ['id' => Auth::user()->id, 'id_product' => $product->id]) }}">
                    @csrf
                    <input type="submit" value="Adicionar à Wishlist">
                </form>
            @endif
        </section>
    @else
        <p>Este produto já se encontra na sua Wishlist</p>
        <a href="{{ route('listWishlist', ['id' => Auth::user()->id]) }}"><button>Minha Wishlist</button></a>
    @endif

    <section class="comments">
        <h4> Comentários </h4>
        <form method="GET" action="{{ route('reviews', ['id_product' => $product->id]) }}" productId="{{$product->id}}" productName="{{$product->nome}}">

            <input type="submit" value="Ver comentarios">
        </form>
    </section>
    @endunless

    <section class="delete">
        @if(Auth::guard('admin')->check())
            @csrf
            <input type="submit" id='editarProduto' value="Editar" action='/products/{{ $product->id }}/edit'>
            <input type="submit" id='alterarStockDoProduto' value="Alterar Stock" action='/products/{{ $product->id }}/changeStock'>
            <input type="submit" id='eliminarProduto' value="Eliminar" action='/products/{{ $product->id }}/delete'>
        @endif
    </section>

</section>

@endsection        

@if (Auth::guard('admin')->check())
    @include('layouts.adminHeaderFooter')
@elseif (Auth::check())
    @include('layouts.userLoggedHeaderFooter')
@else
    @include('layouts.userNotLoggedHeaderFooter')
@endif

