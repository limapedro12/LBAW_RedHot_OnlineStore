<!DOCTYPE html>
<html>
    <head>
        <title>Minhas Encomendas | RedHot</title>
    </head>
    <body>
        <h1>As Minhas Encomendas</h1>
        <ul>
            @foreach ($purchases as $purchase)
                @include ('partials.purchase', ['purchase' => $purchase, 'userId' => $userId])
            @endforeach
        </ul>
    </body>
</html>
