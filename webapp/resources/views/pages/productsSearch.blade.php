<html><body>

    <h1>Lista de Produtos</h1>
    @foreach ($products as $product) 
        <p> {{ $product->ts_rank }} </p>
    @endforeach

</body></html>
