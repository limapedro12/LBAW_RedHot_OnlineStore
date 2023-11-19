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
    let url = String(window.location.href.toString())
    if (url.indexOf('/filter/') > -1) {
        window.location.href = url.substring(0, url.indexOf('/filter/')) + '/filter/' + filterString
    } else if (url.slice(-1) == '/') {
        window.location.href += 'filter/' + filterString;
    } else {
        window.location.href += '/filter/' + filterString;
    }
})