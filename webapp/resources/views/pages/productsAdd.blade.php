
<!DOCTYPE html>
<html>
<head>
    <title>Adicionar Novo Produto</title></head>
<body>
    <h1>Adicionar Novo Produto</h1>

    <form id="addProductForm" method="post" action="{{ route('addProduct') }}">
        @csrf

        <label for="name">Nome:</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="price">Preco:</label>
        <input type="number" id="price" name="price" required><br><br>

        <label for="discount">Desconto:</label>
        <input type="number" step="0.001" id="discount" name="discount" required><br><br>

        <label for="stock">Stock:</label>
        <input type="number" id="stock" name="stock" required><br><br>

        <label for="description">Descrição:</label>
        <textarea id="description" name="description" required></textarea><br><br>

        <label for="url_image">Image URL:</label>
        <input type="text" id="url_image" name="url_image" required><br><br>

        <input type="submit" value="Add Product">
    </form>
</body>
</html>
