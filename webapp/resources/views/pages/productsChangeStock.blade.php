@section('content')
    <section>
        <h1>Alterar o Stock de {{ $product->nome }}</h1>

        <form action="/products/{{ $product->id }}/changeStock" method="POST">
            @csrf

            <label for="stock">Stock:</label>
            <input type="number" id="stock" name="stock" value="{{ $product->stock }}" required><br><br>

            <input type="submit" value="Salvar">
        </form>
    </section>
@endsection

@include('layouts.adminHeaderFooter')
