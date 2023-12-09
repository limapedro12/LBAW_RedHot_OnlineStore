@section('content')
<section>
    <h1>Adicionar Novo Produto</h1>

    <form id="addProductForm" method="post" action="{{ route('addProduct') }} enctype="multipart/form-data"">
        @csrf

        <label for="name">Nome:</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="price">Preco:</label>
        <input type="number" step="0.01" id="price" name="price" required><br><br>

        <label for="discount">Desconto:</label>
        <input type="number" step="0.001" id="discount" name="discount" required><br><br>

        <label for="stock">Stock:</label>
        <input type="number" id="stock" name="stock" required><br><br>

        <label for="description">Descrição:</label>
        <textarea id="description" name="description" required></textarea><br><br>

        <label for="file">Imagem:</label>
        <input type="file" id="file" name="file"><br><br>

        <label for="category">Categoria:</label>
        <input type="text" id="category" name="category"><br><br>

        <input type="submit" value="Adicionar Produto">
    </form>
</section>
@endsection
