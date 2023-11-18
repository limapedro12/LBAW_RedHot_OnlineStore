<html>
    <head>
        <title>Lista de Produtos</title>
        <script src="{{ asset('js/search.js') }}" defer></script>
    <body>
        <h1>Lista de Produtos</h1>
        <form class="search">
            <label for="searchedString">Pesquisa:</label>
            <input type="text" name="searchedString" id="searchedString">
            <input type="submit" value="Pesquisar">
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
