/*<form class="filter">
            <label> Filtros: </label>
            <label>Preco:</label>
            <input type="text" name="priceFilterMin" id="priceFilterMin">
            <input type="text" name="priceFilterMax" id="priceFilterMax">
            <label>Desconto:</label>
            <input type="checkbox" name="discountFilter" id="discountFilter">
            <input type="text" name="discountFilterMin" id="discountFilterMin">
            <input type="text" name="discountFilterMax" id="discountFilterMax">
            <label>Stock:</label>
            <input type="text" name="stockFilterMin" id="stockFilterMin">
            <input type="text" name="stockFilterMax" id="stockFilterMax">
            <input type="submit" value="Filtrar">
        </form>*/

// Filter URL style: /products/filter/preco:min:50;preco:max:100;desconto:min:10;desconto:max:20;stock:min:10;stock:max:20

// if dicountFilter is not checked, discountFilterMin and discountFilterMax should desapear and when discountFilter is checked again, they should reapear    

discountFilterMin.style.display = 'none';
discountFilterMax.style.display = 'none';

document.getElementById('discountFilter').addEventListener('change', function() {
    var discountFilterMin = document.getElementById('discountFilterMin');
    var discountFilterMax = document.getElementById('discountFilterMax');
    if (this.checked) {
        discountFilterMin.style.display = 'block';
        discountFilterMax.style.display = 'block';
    } else {
        discountFilterMin.style.display = 'none';
        discountFilterMax.style.display = 'none';
    }
});

document.querySelector('.filter').addEventListener('submit', function(event) {
    event.preventDefault();
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
    window.location.href += '/filter/' + filterString;
})