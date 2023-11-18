<html>
    <head>
        <title>Lista de Produtos</title>
        <script src="{{ asset('js/search.js') }}" defer></script>
        <script src="{{ asset('js/filter.js') }}" defer></script>
    <body>
        <h1>Lista de Produtos</h1>
        <form class="search">
            <label for="searchedString">Pesquisa:</label>
            <input type="text" name="searchedString" id="searchedString">
            <input type="submit" value="Pesquisar">
        </form>
        <form class="filter">
            <label> Filtros: </label>
            <label>Preco:</label>
            <input type="text" name="priceFilterMin" id="priceFilterMin" placeholder="Min">
            <input type="text" name="priceFilterMax" id="priceFilterMax" placeholder="Max">
            <label>Desconto:</label>
            <input type="checkbox" name="discountFilter" id="discountFilter">
            <input type="text" name="discountFilterMin" id="discountFilterMin" placeholder="Min">
            <input type="text" name="discountFilterMax" id="discountFilterMax" placeholder="Max">
            <label>Stock:</label>
            <input type="text" name="stockFilterMin" id="stockFilterMin" placeholder="Min">
            <input type="text" name="stockFilterMax" id="stockFilterMax" placeholder="Max">
            <input type="submit" value="Filtrar">
        </form>
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
