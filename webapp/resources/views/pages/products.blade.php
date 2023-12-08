@section('content')
    <div class="productsPage">
        <div class="productsPageFilter">
            <div class="productsPageFilterTitle">
                <h2>FILTROS</h2>
            </div>
            <div class="productsPageFilterSelected">
            </div>
            <div class="productsPageFilterFilters">
                <form id="searchAndFilter" class="filterForm">



                    <!-- Range Price Slider -->
                    <div class="rangeContainer">
                        <label class="filtersRangeTitle">Preço:</label>
                        <div class="slidersControl">
                            <input id="fromSlider" type="range" value="1" min="0" max="{{ $maxPrice + 1 }}" />
                            <input id="toSlider" type="range" value="{{ round(($maxPrice + 1) / 2) }}" min="0"
                                max="{{ $maxPrice + 1 }}" />
                        </div>
                        <div class="formControl">
                            <div class="formControlContainer">
                                <div class="formControlContainerTime">Min:</div>
                                <input class="formControlContainerTimeInput" type="number" id="fromInput" value="1"
                                    min="0" max="{{ $maxPrice + 1 }}" />
                            </div>
                            <div class="formControlContainer">
                                <div class="formControlContainerTime">Max:</div>
                                <input class="formControlContainerTimeInput" type="number" id="toInput"
                                    value="{{ round(($maxPrice + 1) / 2) }}" min="0" max="{{ $maxPrice + 1 }}" />
                            </div>
                        </div>
                    </div>

                    <!-- Checkboxes -->
                    <div class="filterCheckboxes">
                        <div class="filterCategoriesList">
                            <label class="filterCheckboxesTitles">Categorias:</label>
                            @foreach ($allCategories as $category)
                                <div class="filterCategoriesListItem">
                                    <input type="checkbox" class="filterCheckbox" name="category"
                                        id="category{{ $category }}" value="{{ $category }}">
                                    <label for="category{{ $category }}">{{ $category }}</label>
                                </div>
                            @endforeach
                        </div>

                        <div class="filterDiscountList">
                            <label class="filterCheckboxesTitles">Desconto:</label>
                            <div class="filterDiscountListItem">
                                <input type="checkbox" class="filterCheckbox" name="discountFilter25" id="discountFilter25"
                                    value="25">
                                <label for="discountFilter25"> até 25 %</label>
                            </div>
                            <div class="filterDiscountListItem">
                                <input type="checkbox" class="filterCheckbox" name="discountFilter50" id="discountFilter50"
                                    value="50">
                                <label for="discountFilter50"> 25 % - 50 %</label>
                            </div>
                            <div class="filterDiscountListItem">
                                <input type="checkbox" class="filterCheckbox" name="discountFilter75" id="discountFilter75"
                                    value="75">
                                <label for="discountFilter75"> 50 % - 75 %</label>
                            </div>
                            <div class="filterDiscountListItem">
                                <input type="checkbox" class="filterCheckbox" name="discountFilter100"
                                    id="discountFilter100" value="100">
                                <label for="discountFilter100"> 75 % - 100 %</label>
                            </div>
                        </div>

                        <div class="filterRatingList">
                            <label class="filterCheckboxesTitles">Rating: </label>
                            <div class="filterRatingListItem">
                                <input type="checkbox" class="filterCheckbox" name="ratingFilter1" id="ratingFilter1"
                                    value="1">
                                <label for="ratingFilter1"> 0 - 1 <i class="fa-solid fa-heart"></i></label>
                            </div>
                            <div class="filterRatingListItem">
                                <input type="checkbox" class="filterCheckbox" name="ratingFilter2" id="ratingFilter2"
                                    value="2">
                                <label for="ratingFilter2"> 1 - 2 <i class="fa-solid fa-heart"></i></label>
                            </div>
                            <div class="filterRatingListItem">
                                <input type="checkbox" class="filterCheckbox" name="ratingFilter3" id="ratingFilter3"
                                    value="3">
                                <label for="ratingFilter3"> 2 - 3 <i class="fa-solid fa-heart"></i></label>
                            </div>
                            <div class="filterRatingListItem">
                                <input type="checkbox" class="filterCheckbox" name="ratingFilter4" id="ratingFilter4"
                                    value="4">
                                <label for="ratingFilter4"> 3 - 4 <i class="fa-solid fa-heart"></i></label>
                            </div>
                            <div class="filterRatingListItem">
                                <input type="checkbox" class="filterCheckbox" name="ratingFilter5" id="ratingFilter5"
                                    value="5">
                                <label for="ratingFilter5"> 4 - 5 <i class="fa-solid fa-heart"></i></label>
                            </div>
                        </div>

                    </div>


                    <div class="filterButtonContainer">
                        <button type="submit">
                            <span class="filterButton">
                                <i class="fas fa-arrow-right"></i>
                            </span>
                        </button>
                    </div>



                </form>
            </div>
        </div>

        <div class="productsPageTop">
            <!-- Search -->
            <label for="searchedString">Pesquisa:</label>
            <input type="text" name="searchedString" id="searchedString">
        </div>

        <div class="productsPageProducts" id='listOfProducts'>
            @foreach ($products as $product)
                <div class="productListItem">
                    <div class="productListItemImg">
                        <a href = "/products/{{ $product->id }}">
                            <img src="{{ $product->url_imagem }}" alt="{{ $product->nome }}"
                                alt="{{ $product->nome }} Image">
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
