<html>
    <body>
        <img style="width: 200px;" src="https://www.paladin.pt/sites/www.paladin.pt/files/styles/product/public/sacana_cannabis_75ml.png?itok=80_qspw0" alt="Imagem de exemplo">
        <section class="productDetails">
            <h2> {{ $product->nome }} </h2> 
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
                <br>
            @endif
        </section>
        <section class='comments'>
            <h4> Comentários </h4>
            To be continued...
        </section>
        
    </body>
</html>