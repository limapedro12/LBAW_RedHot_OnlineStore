<!DOCTYPE html>
<html>
    <head>
        <title>Encomenda {{$purchase->id}} | RedHot</title>
    </head>
    <body>
        <h1>Encomenda {{$purchase->id}}</h1>
        <p>
            <span>Estado: {{$purchase->estado}}</span><br>
            <span>{{$purchase->total}}€</span><br>
            <span>{{$purchase->timestamp}}</span>
        </p>
        <h2>Produtos</h2>
        <ul>
            @foreach($quantPriceProducts as $quantPriceProduct)
                <li>
                    <a href="/products/{{$quantPriceProduct[2]->id}}">{{$quantPriceProduct[2]->nome}}</a>
                    <p>
                        <span>Quantidade: {{$quantPriceProduct[0]}}</span><br>
                        <span>Preço unitário: {{$quantPriceProduct[1]}}€</span><br>
                    </p>
                </li>
            @endforeach
        </ul>
    </body>
</html>
