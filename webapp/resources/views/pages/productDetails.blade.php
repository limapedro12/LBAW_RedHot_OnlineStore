<html>
    <head>
        {{ $product->nome }}
    </head>
    <body>
        <h1>Lista de products</h1>
        <img style="width: 200px;" src="https://www.paladin.pt/sites/www.paladin.pt/files/styles/product/public/sacana_cannabis_75ml.png?itok=80_qspw0" alt="Imagem de exemplo">
        <section class="productDetails">
            <h3> {{ $product->nome }} </h3> 
            <p> 
                <span style = "text-decoration: line-through;">
                    {{ $product->precoatual }}
                </span>
                {{ $discountFunction($product->precoatual, $product->desconto) }} 
            </p>
            @if(product->desconto > 0)
                <p> Desconto: {{ $product->desconto * 100 }}% </p>
                <br>
            @endif
        </section>
        <section class='comments'>
            To be continued...
        </section>
        
    </body>
</html>