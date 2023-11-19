@section('content')
    <h1>Edit Product: {{ $product->nome }}</h1>

    <form action="/products/{{ $product->id }}/edit" method="POST">
        @csrf

        <label for="name">Nome:</label>
        <input type="text" id="name" name="name" value="{{ $product->nome }}" required><br><br>

        <label for="price">Preco:</label>
        <input type="number" id="price" step="0.01" name="price" value="{{ $product->precoatual }}" required><br><br>

        <label for="discount">Desconto:</label>
        <input type="number" step="0.001" id="discount" name="discount" value="{{ $product->desconto }}" required><br><br>

        <label for="stock">Stock:</label>
        <input type="number" id="stock" name="stock" value="{{ $product->stock }}" required><br><br>

        <label for="description">Descrição:</label>
        <textarea id="description" name="description" required>{{ $product->descricao }}</textarea><br><br>

        <label for="url_image">Image URL:</label>
        <input type="text" id="url_image" name="url_image" value="{{ $product->url_imagem }}" required><br><br>

        <input type="submit" value="Save">
    </form>
@endsection

@include('layouts.adminHeaderFooter')
