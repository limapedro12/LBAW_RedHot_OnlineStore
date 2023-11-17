<html>
    <body>
        <h1>Lista de Produtos</h1>
        @foreach ($products as $product) 
            <section class="productListItem">
                <h4> {{ $product->nome }} </h4> 
                <p> 
                    <span style = "text-decoration: line-through;">
                        {{ $product->precoatual }}
                    </span>
                    {{ $discountFunction($product->precoatual, $product->desconto) }} 
                </p>
                @if($product->desconto > 0)
                <p> Desconto: {{ $product->desconto * 100 }}% </p>
                <br>
                @endif
            </section>
        @endforeach
    </body>
</html>
