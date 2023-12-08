// app
try {
  function addEventListeners() {
    let reviewCreator = document.querySelector('form.addReviewForm');
    let ReviewId = document.querySelector('form.addReviewForm').getAttribute('reviewId');
    if (reviewCreator != null) {
      reviewCreator.addEventListener('submit', function (event) {
          sendCreateReviewRequest.call(this, event, ReviewId);
          addReviewAlert();
      });
    }

    let reviewDeleters = document.querySelectorAll('form.deleteReviewForm');
    [].forEach.call(reviewDeleters, function(deleter) {
      deleter.addEventListener('submit', function (event) {
        if(deleteAlert()) {
          let ReviewId = this.getAttribute('reviewId');
          let ProductId = this.getAttribute('productId');
          sendDeleteReviewRequest.call(this, event, ProductId, ReviewId);
        }
        else {
          event.preventDefault();
        }
      });
    });
  }
    
  function encodeForAjax(data) {
    if (data == null) return null;
    return Object.keys(data).map(function(k){
      return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&');
  }

  function sendAjaxRequest(method, url, data, handler) {
    let request = new XMLHttpRequest();

    request.open(method, url, true);
    request.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.addEventListener('load', handler);
    request.send(encodeForAjax(data));
  }

  function sendCreateReviewRequest(event, id) {
    let rating = this.querySelector('input[name=rating]:checked').value;
    let comment = this.querySelector('input[name=comment]').value;
    let timestamp = this.querySelector('input[name=timestamp]').value;

    sendAjaxRequest('post', `/products/${id}/reviews/add_review`, {rating: rating, comment: comment, timestamp:timestamp}, reviewAddedHandler);

    event.preventDefault();
  }

  function sendDeleteReviewRequest(event, id, id_review) {

    sendAjaxRequest('post', `/products/${id}/reviews/${id_review}/delete_review`, null, reviewDeletedHandler);

    event.preventDefault();
  }

  function reviewAddedHandler() {
    if (this.status != 200) window.location = '/';
    let review = JSON.parse(this.responseText);

    // Create the new review
    let new_review = createReview(review);

    // Reset the new review input
    let form = document.querySelector('form.addReviewForm');
    form.querySelector('[type=text]').value="";

    // Insert the new review
    let section = document.querySelector('section#reviews');
    let article = document.querySelector('article.review');
    section.insertBefore(new_review, article);
  }

  function reviewDeletedHandler() {
    if (this.status != 200) window.location = '/';
    let review = JSON.parse(this.responseText);
    let element1 = document.querySelector('article.review[reviewId="' + review.id + '"]');
    let element2 = document.querySelector('form.deleteReviewForm[reviewId="' + review.id + '"]');
    let element3 = document.querySelector('form.editReviewForm[reviewId="' + review.id + '"]');
    element1.remove();
    element2.remove();
    element3.remove();
  }

  function createReview(review) {
    let new_review = document.createElement('article');
    new_review.classList.add('review');
    new_review.setAttribute('reviewId', review.id);

    // Review content
    let reviewContent = document.createElement('p');
    reviewContent.innerHTML = `${review.id_utilizador} -> Rating: ${review.avaliacao} / Comment: ${review.texto} / ${review.timestamp}`;
    new_review.appendChild(reviewContent);

    // Edit form
    let editForm = document.createElement('form');
    editForm.method = 'POST';
    editForm.action = `/products/${review.id_produto}/reviews/${review.id}/edit_review`; 
    editForm.classList.add('editReviewForm');
    editForm.setAttribute('reviewId', review.id);
    let csrfInputEdit = document.createElement('input');
    csrfInputEdit.type = 'hidden';
    csrfInputEdit.name = '_token';
    csrfInputEdit.value = document.querySelector('meta[name="csrf-token"]').content;
    let editSubmitButton = document.createElement('input');
    editSubmitButton.type = 'submit';
    editSubmitButton.value = 'Edit Review';
    editForm.appendChild(csrfInputEdit);
    editForm.appendChild(editSubmitButton);
    new_review.appendChild(editForm);

    return new_review;
  }

  function deleteAlert() {
    let text = "Tem a certeza que pretende eliminar a review?\n";
    if (confirm(text) == true) {
      text = "Review eliminada com sucesso!";
      document.querySelector(".alertMessage").innerHTML = text;
      return true;
    } 
    else {
      text = "Operação cancelada!";
      document.querySelector(".alertMessage").innerHTML = text;
      return false;
    }
  }

  function addReviewAlert() {
    let text = "Review adicionada com sucesso!";
    document.querySelector(".alertMessage").innerHTML = text;
  }

  addEventListeners();
} catch (error) {}

// addProduct

try {
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
        }
    }
    xhr.send(formData);
  });
} catch (error) {}


// header

try {
  const menu_pop = document.querySelector('#menu-bars');
  const navbar = document.querySelector('.headerBar .navbar');


  if (menu_pop != null) {
      menu_pop.addEventListener('click', () => {
          menu_pop.classList.toggle('fa-times');
          navbar.classList.toggle('active');
      });
  }
} catch (error) {}


// searchAndFilter

try {
  function productToHTML(product) {
    var html = `<section class="productListItem">
                <img src = "${product.url_imagem}" alt = "${product.nome}" height = "100">
                <h4> <a href = "/products/${product.id}">${product.nome}</a> </h4>
                <p>`
    if (product.desconto > 0) {
        html += `<span style = "text-decoration: line-through;">${product.precoatual}</span>&nbsp`
    }
        html += discountFunction(product.precoatual, product.desconto);
        html += ` €</p>`;
    if (product.desconto > 0) {
        html += `<p> Desconto: ${product.desconto * 100}% </p>`
    }
        html += `<p>Categoria: ${product.categoria}</p>
                <br>
                </section>`;
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
    var priceFilterMin = document.getElementById('fromInput').value;
    var priceFilterMax = document.getElementById('toInput').value;



    var discountFilter = document.getElementById('discountFilter').checked;
    var discountFilterMin = document.getElementById('discountFilterMin').value;
    var discountFilterMax = document.getElementById('discountFilterMax').value;
    var stockFilterMin = document.getElementById('stockFilterMin').value;
    var stockFilterMax = document.getElementById('stockFilterMax').value;
    var category = document.getElementById('category').value.toLowerCase();
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
    if (category != '') {
        filterString += 'categoria:' + category + ';';
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
} catch (error) {}