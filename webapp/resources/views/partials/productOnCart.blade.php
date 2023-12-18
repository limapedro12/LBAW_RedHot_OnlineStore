<tr>
    <td>
        <div class="cartProductImage">
            <a href="/products/{{ $product->id }}">
                <img src="{{ $product->getProductImage() }}" alt="Imagem de {{ $product->nome }}">
            </a>
        </div>
    </td>
    <td>
        <div class="cartProductNameCategory">
            <a href="/products/{{ $product->id }}">{{ $product->nome }}</a>
            <p>{{ $product->categoria }}</p>
        </div>
    </td>
    <td>
        <div class="cartProductDiscount">
            <p>
                @if ($product->desconto > 0)
                    {{ $product->desconto * 100 }}%
                @else
                    Sem desconto
                @endif
            </p>
        </div>
    </td>
    <td>
        <div class="cartProductPrices">
            @if ($product->desconto > 0)
                <p class="cartOldPrice"> {{ $product->precoatual }} €</p>
            @endif
            <p>{{ round($discountFunction($product->precoatual, $product->desconto), 2) }} €</p>
        </div>
    </td>
    <td>
        <div class="cartQuantityChange">
            <button class="removeQuantity"> <i class="fas fa-minus"></i> </button>
            <input class="cartProductQuantity" type="number" name="quantity" value="{{ $quantidade }}" min="1"
                max="{{ $product->stock }}" product_id="{{ $product->id }}">
            <button class="addQuantity"> <i class="fas fa-plus"></i> </button>
        </div>
    </td>
    <td>
        <div class="cartProductTotal">
            <p>{{ round($discountFunction($product->precoatual, $product->desconto) * $quantidade, 2) }} €</p>
        </div>
    </td>
    <td>
        <div class="cartRemoveProduct">
            <form method=post action="/cart/remove_product">
                @csrf
                <input type=hidden name="id_produto" value="{{ $product->id }}">
                <button type="submit"><i class="fas fa-xmark"></i> </button>
            </form>
        </div>
    </td>
</tr>
