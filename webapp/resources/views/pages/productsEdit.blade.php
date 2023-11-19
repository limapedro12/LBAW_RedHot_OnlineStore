
<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
</head>
<body>
    <h1>Edit Product: {{ $product->name }}</h1>

    <form action="/products/{{ $product->id }}" method="POST">
        @csrf

        <label for="name">Nome:</label>
        <input type="text" id="name" name="name" value="{{ $product->name }}" required><br><br>

        <label for="price">Preco:</label>
        <input type="number" id="price" name="price" value="{{ $product->price }}" required><br><br>

        <label for="discount">Desconto:</label>
        <input type="number" step="0.001" id="discount" name="discount" value="{{ $product->discount }}" required><br><br>

        <label for="stock">Stock:</label>
        <input type="number" id="stock" name="stock" value="{{ $product->stock }}" required><br><br>

        <label for="description">Descrição:</label>
        <textarea id="description" name="description" required>{{ $product->description }}</textarea><br><br>

        <label for="url_image">Image URL:</label>
        <input type="text" id="url_image" name="url_image" value="{{ $product->url_image }}" required><br><br>

        <input type="submit" value="Save">
    </form>
</body>
</html>
