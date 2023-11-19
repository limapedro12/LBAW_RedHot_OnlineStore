document.getElementById('addProductForm').addEventListener('submit', function(event) {
    event.preventDefault();

    var name = document.getElementById('name').value;
    var price = document.getElementById('price').value;
    var stock = document.getElementById('stock').value;
    var description = document.getElementById('description').value;
    var image_url = document.getElementById('image').value;

    var formData = new FormData();
    formData.append('nome', name);
    formData.append('preco', price);
    formData.append('stock', stock);
    formData.append('descricao', description);
    formData.append('url_imagem', image_url);


    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/products/add', true);
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.onreadystatechange = function () {
        if(xhr.readyState === 4 && xhr.status === 200) {
            var json = JSON.parse(xhr.responseText);
            console.log(json);
        }
    }
    xhr.send(formData);
});