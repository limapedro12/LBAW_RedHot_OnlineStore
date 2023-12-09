@section('content')
<section>
    <h1>Edit Product: {{ $product->nome }}</h1>

    <form action="/products/{{ $product->id }}/edit" method="POST" enctype="multipart/form-data">
        @csrf

        <label for="name">Nome:</label>
        <input type="text" id="name" name="name" value="{{ $product->nome }}" required><br><br>

        <label for="price">Preco:</label>
        <input type="number" id="price" step="0.01" name="price" value="{{ $product->precoatual }}" required><br><br>

        <label for="discount">Desconto:</label>
        <input type="number" step="0.001" id="discount" name="discount" value="{{ $product->desconto }}"><br><br>

        <label for="stock">Stock:</label>
        <input type="number" id="stock" name="stock" value="{{ $product->stock }}" required><br><br>

        <label for="description">Descrição:</label>
        <textarea id="description" name="description" required>{{ $product->descricao }}</textarea><br><br>

        <div id="photoUploader">
            <label for="file">Imagem:</label><br>
            <input name="file" type="file" id="file"><br><br>
        </div>
        @if ($product->hasPhoto())
        <label for="deletePicture">Apagar Imagem</label>
        <input type="checkbox" id="deletePhoto" name="deletePhoto"><br><br>
        @endif

        <label for="category">Categoria:</label>
        <input type="text" id="category" name="category" value="{{ $product->categoria }}"><br><br>

        <input type="submit" value="Guardar">
    </form>
</section>
@endsection

@include('layouts.adminHeaderFooter')
