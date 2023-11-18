<html>
    <body>
        <h1>Lista de Produtos</h1>
        <h3> Filtros: {{ $filter }} </h3>
        @include('partials.searchAndFilterForms', ['searchedString' => '', 
                                                   'filterPriceMax' => $filterArr['priceMax'],
                                                    'filterPriceMin' => $filterArr['priceMin'],
                                                    'filterDiscount' => $filterArr['discount'],
                                                    'filterDiscountMax' => $filterArr['discountMax'],
                                                    'filterDiscountMin' => $filterArr['discountMin'],
                                                    'filterStockMax' => $filterArr['stockMax'],
                                                    'filterStockMin' => $filterArr['stockMin']])
        @foreach ($products as $product) 
            <section class="productListItem">
                <h4> {{ $product->nome }} </h4> 
                <p> 
                    @if($product->desconto > 0)
                        <span style = "text-decoration: line-through;">
                            {{ $product->precoatual }}
                        </span>&nbsp
                    @endif
                    {{ $discountFunction($product->precoatual, $product->desconto) }} 
                </p>
                @if($product->desconto > 0)
                <p> Desconto: {{ $product->desconto * 100 }}% </p>
                @endif
                <br>
            </section>
        @endforeach
    </body>
</html>
