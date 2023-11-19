function productToHTML(product) {
    var html = '<section class="productListItem">';
    html += '<h4> <a href = "/products/' + product.id + '"> ' + product.nome + ' </a> </h4>';
    html += '<p>';
    if (product.desconto > 0) {
        html += '<span style = "text-decoration: line-through;">' + product.precoatual + '</span>&nbsp';
    }
    html += discountFunction(product.precoatual, product.desconto);
    html += '</p>';
    if (product.desconto > 0) {
        html += '<p> Desconto: ' + (product.desconto * 100) + '% </p>';
    }
    html += '<br>';
    html += '</section>';
    return html;
}

function discountFunction(precoatual, desconto) {
    // Implement your discount function here
    // For example:
    return Math.round((precoatual - precoatual * desconto) * 100) / 100
}

listOfProducts = document.getElementById('listOfProducts');

function displayDiscountFilter() {
    var discountFilterMin = document.getElementById('discountFilterMin');
    var discountFilterMax = document.getElementById('discountFilterMax');
    if (document.getElementById('discountFilter').checked) {
        discountFilterMin.style.display = 'inline-block';
        discountFilterMax.style.display = 'inline-block';
    } else {
        discountFilterMin.style.display = 'none';
        discountFilterMax.style.display = 'none';
    }
}

displayDiscountFilter()

document.getElementById('discountFilter').addEventListener('change', displayDiscountFilter);

document.getElementById('searchAndFilter').addEventListener('submit', function(event) {
    event.preventDefault();

    listOfProducts.innerHTML = '<img src="https://i.gifer.com/ZKZg.gif" alt="Loading...">';

    //search part
    var searchString = document.getElementById('searchedString').value

    //filter part
    var priceFilterMin = document.getElementById('priceFilterMin').value;
    var priceFilterMax = document.getElementById('priceFilterMax').value;
    var discountFilter = document.getElementById('discountFilter').checked;
    var discountFilterMin = document.getElementById('discountFilterMin').value;
    var discountFilterMax = document.getElementById('discountFilterMax').value;
    var stockFilterMin = document.getElementById('stockFilterMin').value;
    var stockFilterMax = document.getElementById('stockFilterMax').value;
    var filterString = '';
    if (priceFilterMin != '') {
        filterString += 'preco:min:' + priceFilterMin + ';';
    }
    if (priceFilterMax != '') {
        filterString += 'preco:max:' + priceFilterMax + ';';
    }
    if (discountFilter) {
        filterString += 'desconto;';
    }
    if (discountFilterMin != '') {
        filterString += 'desconto:min:' + discountFilterMin + ';';
    }
    if (discountFilterMax != '') {
        filterString += 'desconto:max:' + discountFilterMax + ';';
    }
    if (stockFilterMin != '') {
        filterString += 'stock:min:' + stockFilterMin + ';';
    }
    if (stockFilterMax != '') {
        filterString += 'stock:max:' + stockFilterMax + ';';
    }

    if(searchString == '')
        searchString = '*'
    if(filterString == '')
        filterString = '*'
    url = '/products/search/' + encodeURIComponent(searchString) + '/filter/' + filterString + '/API'

    //use XMLHttpRequest to send the request to the server
    var xhr = new XMLHttpRequest();
    xhr.open('GET', url, true);

    //when the request comes back, run the following code
    xhr.onload = function() {
        //if everything went ok, show the search results
        if (xhr.status == 200) {
            let products = JSON.parse(xhr.responseText);
            listOfProducts.innerHTML = Object.values(products).map(productToHTML).join('');
        }
        //if something went wrong, show the error
        else {
            listOfProducts.innerHTML = '<p>Error: ' + xhr.status + '</p>';
        }
    };

    //send the request
    xhr.send();
})