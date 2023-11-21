<!DOCTYPE html>
<html>
<head>
    <title>Carrinho | RedHot</title>
    <body>
        <h1>Carrinho</h1>
        <ul>
            @foreach ($list as $elem)
                @include ('partials.productOnCart', ['quantidade' => $elem[0],
                                                    'product' => $elem[1]])
            @endforeach
        </ul>
        <p>Total: {{$total}} €</p>
        @if (count($list) > 0)
        <a href="/cart/checkout"><button>Checkout</button></a>
        @endif
    </body>
</html>
