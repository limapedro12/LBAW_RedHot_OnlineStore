@section('content')
    <?php
    use App\Models\Product;
    
    $destaques = Product::where('destaque', 1)->get();
    $discountFunction = function ($price, $discount) {
        return $price * (1 - $discount);
    };
    ?>

    <div class='home'>
        <img src="{{ asset('sources/main/teste-main-3.png') }}" alt="Termos de Uso" class="background">
        <div class='buttonOnHome'>
            <a href="{{ url('/about') }}"> Sobre Nós</a>
        </div>
    </div>
    <div class='mainDestaques'>
        <div class="backgroundMain">
            <img src="{{ asset('sources/main/teste-main-5.png') }}" alt="Destaques" class="backgroundDestaques">
        </div>
        <div class='top4SellingProducts'>
            <div class='top4SellingProductsTitle'>
                <h2>Produtos em Destaque</h2>
            </div>
            <div class='top4SellingProductsList'>
                <div class="productsPageProducts" id='listOfProducts'>
                    @foreach ($destaques as $product)
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
                                            <p class="euro">€ </p>
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
        </div>
    </div>
@endsection

@if (Auth::guard('admin')->check())
    @include('layouts.adminHeaderFooter')
@elseif (Auth::check())
    @include('layouts.userLoggedHeaderFooter')
@else
    @include('layouts.userNotLoggedHeaderFooter')
@endif
