<li>
    <a href="/products/{{ $product->id }}">{{ $product->nome }}</a>
    <img src="{{ $product->getProductImage() }}" alt="Imagem de {{ $product->nome }}" height = "100">
    <p>
        @if ($product->desconto > 0)
            <span style = "text-decoration: line-through;">
                {{ $quantidade }} x {{ $product->precoatual }} =
                {{ $product->precoatual * $quantidade }}
            </span>&nbsp
        @endif
        {{ $quantidade }} x {{ $discountFunction($product->precoatual, $product->desconto) }} =
        {{ $discountFunction($product->precoatual, $product->desconto) * $quantidade }} €
    <form method=post action="/cart/remove_product">
        @csrf
        <input type=hidden name="id_produto" value="{{ $product->id }}">
        <button type="submit">Remover</button>
    </form>
    </p>
</li>
