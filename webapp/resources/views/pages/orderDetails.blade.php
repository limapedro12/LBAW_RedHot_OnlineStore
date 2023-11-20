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
            @foreach($quantProducts as $quantProduct)
                <li>
                    <a href="/products/{{$quantProduct[1]->id}}">{{$quantProduct[1]->nome}}</a>
                    <p>
                        <span>Quantidade: {{$quantProduct[0]}}</span><br>
                        <span>Preço: {{$quantProduct[1]->precoatual*(1-$quantProduct[1]->desconto)}}€</span><br>
                    </p>
                </li>
            @endforeach
        </ul>
    </body>
</html>
