@section('content')
    <div class="productsPage">
        <div class="productsPageFilter">
            <div class="productsPageFilterTitle">
                <h2>Filtros</h2>
            </div>
            <div class="productsPageFilterSelected">
            </div>
            <div class="productsPageFilterFilters">
                @include('partials.searchAndFilterForms')
            </div>
        </div>

        <div class="productsPageTop">
        </div>

        <div class="productsPageProducts" id='listOfProducts'>
            @foreach ($products as $product)
                <div class="productListItem">
                    <div class="productListItemImg">
                        <a href = "/products/{{ $product->id }}">
                            <img src="{{ $product->url_imagem }}" alt="{{ $product->nome }}" alt="{{ $product->nome }} Image">
                        </a>
                    </div>
                    <div class="productListItemTitle">
                        <a href = "/products/{{ $product->id }}"> 
                            <h3> 
                                {{ $product->nome }} 
                            </h3>
                        </a> 
                    </div>
                    <!--
                    <div class="productListItemCategory">
                        <p> {{ $product->categoria }} </p>
                    </div>
                -->
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
                                    <p class="euro">€ </p>
                                </div>
                                <div class="productListItemNewPrice">
                                    <p class="newPrices">
                                        {{ round($discountFunction($product->precoatual, $product->desconto), 2) }} €
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
@endsection

@if (Auth::guard('admin')->check())
    @include('layouts.adminHeaderFooter')
@elseif (Auth::check())
    @include('layouts.userLoggedHeaderFooter')
@else
    @include('layouts.userNotLoggedHeaderFooter')
@endif
