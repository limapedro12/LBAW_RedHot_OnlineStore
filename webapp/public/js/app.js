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
    [].forEach.call(reviewDeleters, function (deleter) {
      deleter.addEventListener('submit', function (event) {
        if (deleteAlert()) {
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
    return Object.keys(data).map(function (k) {
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

    sendAjaxRequest('post', `/products/${id}/reviews/add_review`, { rating: rating, comment: comment, timestamp: timestamp }, reviewAddedHandler);

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
    form.querySelector('[type=text]').value = "";

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

    let userIdHeading = document.createElement('h3');
    userIdHeading.textContent = `Utilizador: ${review.id_utilizador}`;
    new_review.appendChild(userIdHeading);

    let ratingHeading = document.createElement('h3');
    ratingHeading.textContent = `Avaliação: ${review.avaliacao}`;
    new_review.appendChild(ratingHeading);

    let commentHeading = document.createElement('h4');
    commentHeading.textContent = `Comentário: ${review.texto}`;
    new_review.appendChild(commentHeading);

    let timestampParagraph = document.createElement('p');
    timestampParagraph.textContent = review.timestamp;
    new_review.appendChild(timestampParagraph);

    // Edit form
    let editForm = document.createElement('form');
    editForm.method = 'GET';
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
    Swal.fire({
      title: "Sucesso!",
      text: "O comentario foi apagado com sucesso!",
      icon: "success"
    });
    return true;
  }

  function addReviewAlert() {
    Swal.fire({
      title: "Sucesso!",
      text: "O comentario foi adicionado com sucesso!",
      icon: "success"
    });
  }

  addEventListeners();

} catch (error) { }

// cart

try {
  function addEventListeners() {
    let productCartAdder = document.querySelector('form.addToCart');
    if (productCartAdder != null) {
      productCartAdder.addEventListener('submit', function () {
        productCartAlert();
      });
    }
  }

  function productCartAlert() {
    let timerInterval;
    Swal.fire({
      title: "Produto adicionado ao carrinho!",
      html: "Esta mensagem fecha automaticamente",
      timer: 1700,
      timerProgressBar: true,
      didOpen: () => {
        Swal.showLoading();
      },
      willClose: () => {
        clearInterval(timerInterval);
      }
    }).then((result) => {
      if (result.dismiss === Swal.DismissReason.timer) {
        console.log("I was closed by the timer");
      }
    });
  }

  addEventListeners();

} catch (error) { }

// checkout
try {
  function addEventListeners() {
    let productCartAdder = document.querySelector('form.checkoutForm');
    if (productCartAdder != null) {
      productCartAdder.addEventListener('submit', function () {
        productCartAlert();
      });
    }
  }

  function productCartAlert() {
    let timerInterval;
    Swal.fire({
      title: "A Compra está a ser processada!",
      html: "Esta mensagem fecha automaticamente",
      timer: 1000,
      timerProgressBar: true,
      didOpen: () => {
        Swal.showLoading();
      },
      willClose: () => {
        clearInterval(timerInterval);
      }
    }).then((result) => {
      if (result.dismiss === Swal.DismissReason.timer) {
        console.log("I was closed by the timer");
      }
    });
  }

  addEventListeners();

} catch (error) { }


//wishlist

try {
  function addEventListeners() {
    let productWishlistAdder = document.querySelector('form.addToWishlist');
    if (productWishlistAdder != null) {
      productWishlistAdder.addEventListener('submit', function () {
        productWishlistAlert();
      });
    }
  }

  function productWishlistAlert() {
    Swal.fire({
      title: "Sucesso!",
      text: "O produto foi adicionado à wishlist com sucesso!",
      icon: "success",
      showConfirmButton: false
    });
  }

  addEventListeners();

} catch (error) { }

// cancelar encomenda

try {
  function addEventListeners() {
    let orderCanceler = document.querySelector('form.cancelOrder');
    if (orderCanceler != null) {
      orderCanceler.addEventListener('submit', function () {
        orderCancelAlert();
      });
    }
  }

  function orderCancelAlert() {
    Swal.fire({
      title: "Sucesso!",
      text: "A encomenda foi cancelada com sucesso!",
      icon: "success",
      showConfirmButton: false
    });
  }

  addEventListeners();

} catch (error) { }

// edit review

try {
  function addEventListeners() {
    let reviewEditor = document.querySelector('form.editEachReview');
    if (reviewEditor != null) {
      reviewEditor.addEventListener('submit', function () {
        reviewEditAlert();
      });
    }
  }

  function reviewEditAlert() {
    Swal.fire({
      title: "A ser Processado!",
      text: "O comentario foi editado com sucesso!",
      icon: "success",
      showConfirmButton: false
    });
  }

  addEventListeners();

} catch (error) { }

// edit password

try {
  function addEventListeners() {
    let passwordEditor = document.querySelector('form.editPassForm');
    if (passwordEditor != null) {
      passwordEditor.addEventListener('submit', function () {
        passwordEditAlert();
      });
    }
  }

  function passwordEditAlert() {
    Swal.fire({
      title: "Sucesso!",
      text: "A password foi alterada com sucesso!",
      icon: "success",
      showConfirmButton: false
    });
  }

  addEventListeners();

} catch (error) { }

// register

try {
  function addEventListeners() {
    let register = document.querySelector('form.signupForm');
    if (register != null) {
      register.addEventListener('submit', function () {
        registerAlert();
      });
    }
  }

  function registerAlert() {
    Swal.fire({
      title: "Sucesso!",
      text: "O registo foi efetuado com sucesso!",
      icon: "success",
      showConfirmButton: false
    });
  }

  addEventListeners();

} catch (error) { }


// addPromoCode

try {
  function addEventListeners() {
    let promoCode = document.querySelector('form.addPromoCodeForm');
    if (promoCode != null) {
      promoCode.addEventListener('submit', function () {
        promoCodeAlert();
      });
    }
  }

  function promoCodeAlert() {
    let timerInterval;
    Swal.fire({
      title: "A tentar adicionar o novo Promo Code!",
      html: "Esta mensagem fecha automaticamente",
      timer: 700,
      timerProgressBar: true,
      didOpen: () => {
        Swal.showLoading();
      },
      willClose: () => {
        clearInterval(timerInterval);
      }
    }).then((result) => {
      if (result.dismiss === Swal.DismissReason.timer) {
        console.log("I was closed by the timer");
      }
    });
  }

  addEventListeners();

} catch (error) { }


// addProduct

try {
  document.getElementById('addProductForm').addEventListener('submit', function (event) {
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
      if (xhr.readyState === 4 && xhr.status === 200) {
        var json = JSON.parse(xhr.responseText);
      }
    }
    xhr.send(formData);
  });
} catch (error) { }


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
} catch (error) { }


// searchAndFilter
function discountFunction(precoatual, desconto) {
  return Math.round((precoatual - precoatual * desconto) * 100) / 100
}


let productTemplateOriginal = (document.getElementsByClassName('productListItem').length > 0) ?
  document.getElementsByClassName('productListItem')[0].cloneNode(true) :
  null


function createProductHTML(product) {
  let productTemplate = productTemplateOriginal.cloneNode(true)
  productTemplate.getElementsByClassName('productImage')[0].src = product.url_imagem
  productTemplate.getElementsByClassName('productImage')[0].alt = product.nome
  productTemplate.getElementsByClassName('productListItemTitleLink')[0].href = `/products/${product.id}`
  productTemplate.getElementsByClassName('productListItemTitleText')[0].innerHTML = product.nome
  productTemplate.getElementsByClassName('productListItemNumberOfReviews')[0].querySelector('p').innerHTML = `${product.numero_reviews} avaliações`
  productTemplate.getElementsByClassName('productListItemAverageRating')[0].innerHTML = product.avaliacao_media

  // Create a parent container
  let container = productTemplate.getElementsByClassName('productListItemPrices')[0];
  container.innerHTML = '';

  if (product.desconto > 0) {
    let oldPriceDiv = document.createElement('div');
    oldPriceDiv.className = "productListItemOldPrice";

    let discountP = document.createElement('p');
    discountP.className = "discount";
    discountP.textContent = Math.round(product.desconto * 100) + "%";
    oldPriceDiv.appendChild(discountP);

    let oldPriceP = document.createElement('p');
    oldPriceP.className = "oldPrices";
    oldPriceP.textContent = product.precoatual;
    oldPriceDiv.appendChild(oldPriceP);

    let euroP = document.createElement('p');
    euroP.className = "euro";
    euroP.textContent = "€";
    oldPriceDiv.appendChild(euroP);

    container.appendChild(oldPriceDiv);

    let newPriceDiv = document.createElement('div');
    newPriceDiv.className = "productListItemNewPrice";

    let newPriceP = document.createElement('p');
    newPriceP.className = "newPrices";
    newPriceP.textContent = discountFunction(product.precoatual, product.desconto) + " €";
    newPriceDiv.appendChild(newPriceP);

    container.appendChild(newPriceDiv);
  } else {
    let priceDiv = document.createElement('div');
    priceDiv.className = "productListItemPrice";

    let priceP = document.createElement('p');
    priceP.className = "Price";
    priceP.textContent = product.precoatual + "€";
    priceDiv.appendChild(priceP);

    container.appendChild(priceDiv);
  }

  return productTemplate.outerHTML
}

if (document.getElementsByClassName('productsPageFilter').length > 0) {

  document.querySelector('form.productSearchForm').addEventListener('submit', function (event) {
    event.preventDefault();
  })

  document.querySelector('form#filterForm').addEventListener('submit', function (event) {
    event.preventDefault();
  })

  listOfProducts = document.getElementById('listOfProducts');

  // document.querySelector('.filterButtonContainer > button').addEventListener('click', function(event) {
  function filterProducts(event) {
    //search part
    let searchString = document.getElementById('searchedString').value

    let filterJSON = {}

    //filter part
    let priceFilterMin = document.getElementById('fromInput').value;
    let priceFilterMax = document.getElementById('toInput').value;
    filterJSON.price = { "min": priceFilterMin, "max": priceFilterMax }

    let categorias = Array.from(document.getElementsByClassName('filterCategoriesListItem'))
      .filter(e => e.querySelector('input').checked)
      .map(e => e.querySelector('input').value)
    filterJSON.categories = categorias

    let discountList = []
    if (document.getElementById('discountFilter25').checked)
      discountList.push({ "min": 0, "max": 0.25 })
    if (document.getElementById('discountFilter50').checked)
      discountList.push({ "min": 0.25, "max": 0.5 })
    if (document.getElementById('discountFilter75').checked)
      discountList.push({ "min": 0.5, "max": 0.75 })
    if (document.getElementById('discountFilter100').checked)
      discountList.push({ "min": 0.75, "max": 1 })
    filterJSON.discount = discountList

    let ratingList = []
    if (document.getElementById('ratingFilter1').checked)
      ratingList.push({ "min": 0, "max": 1 })
    if (document.getElementById('ratingFilter2').checked)
      ratingList.push({ "min": 1, "max": 2 })
    if (document.getElementById('ratingFilter3').checked)
      ratingList.push({ "min": 2, "max": 3 })
    if (document.getElementById('ratingFilter4').checked)
      ratingList.push({ "min": 3, "max": 4 })
    if (document.getElementById('ratingFilter5').checked)
      ratingList.push({ "min": 4, "max": 5 })
    filterJSON.rating = ratingList

    filterJSON.orderBy = document.querySelector('select.productsPageSortSelector').value

    var filterString = JSON.stringify(filterJSON)

    if (searchString == '')
      searchString = '*'

    url = '/products/search/' + encodeURIComponent(searchString) + '/filter/' + filterString + '/API'

    // use XMLHttpRequest to send the request to the server
    var xhr = new XMLHttpRequest();
    xhr.open('GET', url, true);

    //when the request comes back, run the following code
    xhr.onload = function () {
      //if everything went ok, show the search results
      if (xhr.status == 200) {
        let products = JSON.parse(xhr.responseText);
        listOfProducts.innerHTML = Object.values(products).map(createProductHTML).join('');
      }
      //if something went wrong, show the error
      else {
        listOfProducts.innerHTML = '<p>Error: ' + xhr.status + '</p>';
      }
    };
    xhr.send();
  }

  document.getElementById('searchedString').addEventListener('keypress', filterProducts)
  Array.from(document.querySelectorAll('input')).map(e => e.addEventListener('change', filterProducts))
  document.querySelector('select.productsPageSortSelector').addEventListener('change', filterProducts)
}

// change purchase state

function addRedirectToNotification(notification) {
  let link = notification.getAttribute('link_to_redirect')
  notification.addEventListener('click', function (event) {
    location.href = link
  })
}

function markAsRead(id) {
  let xhr = new XMLHttpRequest()
  xhr.open('PUT', `/notifications/${id}/markAsRead`, true)
  xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest')
  xhr.send()
}

function addDeleteNotificationButton(notification) {
  notification.querySelector('button').addEventListener('click', function (event) {
    event.preventDefault()
    let action = notification.querySelector('form').getAttribute('action')
    let csrf_token = document.querySelector('input[name="_token"]').value
    let xhr = new XMLHttpRequest()
    xhr.open('DELETE', action, true)
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest')
    xhr.setRequestHeader('X-CSRF-TOKEN', csrf_token)
    xhr.send()
    notification.remove()
  })
}

function changeStateInSpecificPages(data) {
  if (location.href.match(/[^\/]+\/\/[^\/]+\/users\/[0-9]+\/notifications/) ||
    location.href.match(/[^\/]+\/\/[^\/]+\/admin\/[0-9]+\/notifications/)) {
    let all_notifications = document.getElementsByClassName('notification-list')[0]
    let notification = all_notifications.getElementsByClassName('notification-item-list')[0].cloneNode(true)

    notification.setAttribute('link_to_redirect', data.linkToRedirect)
    notification.getElementsByClassName('notification-timestamp')[0].innerHTML = data.timestamp
    notification.getElementsByClassName('notification-body')[0].innerHTML = data.message
    notification.querySelector('form').setAttribute('action', `/notifications/${data.notificationId}/delete`)
    let new_notification_marker = notification.getElementsByClassName('new-notification')
    if (new_notification_marker.length == 0) {
      let new_notification_marker = document.createElement('small')
      new_notification_marker.classList.add('new-notification')
      new_notification_marker.innerHTML = 'Nova'
      notification.childNodes[1].insertBefore(new_notification_marker, notification.childNodes[1].childNodes[2])
      notification.childNodes[1].insertBefore(document.createTextNode(' '), notification.childNodes[1].childNodes[2])
    }

    addDeleteNotificationButton(notification)

    all_notifications.insertBefore(notification, all_notifications.firstChild)
  }
  if (data.purchaseId != null)
    Array.from(document.getElementsByClassName(`order${data.purchaseId}State`)).map(e => e.innerHTML = `Estado: ${data.newState}`)
}


function showNotification(data) {
  var notification = document.createElement("div")
  notification.setAttribute('link_to_redirect', data.linkToRedirect)
  notification.innerHTML = data.message
  addRedirectToNotification(notification)
  notification.classList.add("notification")
  document.body.appendChild(notification)
  markAsRead(data.notificationId)
  changeStateInSpecificPages(data)
  setTimeout(() => {
    document.body.removeChild(notification)
  }, 16000)
}

if (document.querySelector('user') != null) {
  let user_id = document.querySelector('user').getAttribute('user_id')
  const pusher = new Pusher("7a447c0e0525f5f86bc9", {
    cluster: "eu",
    encrypted: true
  })

  const channel = pusher.subscribe('RedHot')
  channel.bind('notification-to-user-' + user_id, function (data) {
    showNotification(data)
  })
}

if (document.querySelector('admin') != null) {
  let admin_id = document.querySelector('admin').getAttribute('admin_id')
  const pusher = new Pusher("7a447c0e0525f5f86bc9", {
    cluster: "eu",
    encrypted: true
  })

  const channel = pusher.subscribe('RedHot')
  channel.bind('notification-to-all-admins', function (data) {
    showNotification(data)
  })
  channel.bind('notification-to-admin-' + admin_id, function (data) {
    showNotification(data)
  })
}

notifications = document.getElementsByClassName('notification-item-list')
if (notifications.length > 0) {
  Array.from(notifications)
    .map(n => n.getElementsByClassName('notification-clickable')[0])
    .map(addRedirectToNotification)
  Array.from(notifications)
    .filter(n => n.getElementsByClassName('new-notification').length > 0)
    .map(n => n.getAttribute('notification_id'))
    .map(markAsRead)
  Array.from(notifications).map(addDeleteNotificationButton)
}

editButton = document.getElementById('editarProduto')
if (editButton != null) {
  editButton.addEventListener('click', function (event) {
    event.preventDefault()
    location.href = editButton.getAttribute('action')
  })
}

stockButton = document.getElementById('alterarStockDoProduto')
if (stockButton != null) {
  stockButton.addEventListener('click', function (event) {
    event.preventDefault()
    location.href = stockButton.getAttribute('action')
  })
}

deleteButton = document.getElementById('eliminarProduto')
if (deleteButton != null) {
  deleteButton.addEventListener('click', function (event) {
    event.preventDefault()
    if (confirm('Tem a certeza de que pretende eliminar este produto?')) {
      let action = deleteButton.getAttribute('href')
      let csrf_token = document.querySelector('input[name="_token"]').value
      let xhr = new XMLHttpRequest()
      xhr.open('DELETE', action, true)
      xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest')
      xhr.setRequestHeader('X-CSRF-TOKEN', csrf_token)
      xhr.send()
      location.href = '/adminProductsManage'
    }
  })
}

// delete profile picture
try {
  uploader = document.getElementsByClassName('filesBox')[0]
  checkBox = document.getElementById('deletePhoto');
  checkBox.addEventListener('click', function (event) {
    if (checkBox.checked) {
      uploader.style.display = 'none';
    } else {
      uploader.style.display = 'block';
    }
  });
} catch (error) {}

// uploaded image
let input_img = document.getElementById('file');
let img_name = document.getElementById('fileImgName');

if (input_img != null) {

  input_img.addEventListener('change', () => {
    let inputImage = document.querySelector('input[id=file]').files[0];
    img_name.innerText = inputImage.name;
  });

}

// Faqs
const faqs = document.querySelectorAll('.faq');
if (faqs != null) {
  faqs.forEach(faq => {
    faq.addEventListener('click', () => {
      faq.classList.toggle('active');
    });
  });
}

function sendPutRequestTo(url){
  let xhr = new XMLHttpRequest()
  xhr.open('PUT', url, true)
  xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest')
  xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content)
  xhr.send()
}

function addEventsToQuantityButtons(product){
  let id = product.getAttribute('product_id');
  let minus_button = product.querySelector('button.removeQuantity')
  let plus_button = product.querySelector('button.addQuantity')
  let quantity_input = product.querySelector('input.cartProductQuantity')
  if(parseInt(quantity_input.value) == parseInt(quantity_input.max)){
    plus_button.style.opacity = '0.5'
  }
  console.log(quantity_input)
  minus_button.addEventListener('click', function(event){
    event.preventDefault()
    sendPutRequestTo('/cart/decreaseQuantity/' + id)
    if(quantity_input.value == 1){
      product.remove()
    } else {
      quantity_input.value = parseInt(quantity_input.value) - 1
      if(parseInt(quantity_input.value) < parseInt(quantity_input.max)){
        plus_button.style.opacity = '1'
      }
    }
  })
  plus_button.addEventListener('click', function(event){
    event.preventDefault()
    if(parseInt(quantity_input.value) < parseInt(quantity_input.max)){
      sendPutRequestTo('/cart/increaseQuantity/' + id)
      quantity_input.value = parseInt(quantity_input.value) + 1
      if(parseInt(quantity_input.value) == parseInt(quantity_input.max)){
        plus_button.style.opacity = '0.5'
      }
    }
  })
  quantity_input.addEventListener('input', function(event){
    if(!isNaN(parseInt(quantity_input.value)) && parseInt(quantity_input.value) > 0){
      if(parseInt(quantity_input.value) <= parseInt(quantity_input.max)){
        sendPutRequestTo('/cart/setQuantity/' + id + '/' + quantity_input.value)
        product.querySelector("small.quantityError").innerHTML = ""
      } else {
        product.querySelector("small.quantityError").innerHTML = "Quantidade máxima: " + quantity_input.max
      }
    }
    if(parseInt(quantity_input.value) == parseInt(quantity_input.max)){
      plus_button.style.opacity = '0.5'
    }
  })
}

if(document.getElementsByClassName('cartTitle').length > 0){
  productList = document.querySelectorAll('tr.productRow')
  Array.from(productList).map(addEventsToQuantityButtons)
}

// checkout
try {
  method_card = document.getElementById('method-card');
  method_mbway = document.getElementById('method-mbway');
  radio = document.getElementsByName('paymentMethod');
  radio.forEach(element => {
    element.addEventListener('click', function () {
      if (element.value == 'cash') {
        method_card.style.display = 'none';
        method_mbway.style.display = 'none';
      }
      else if (element.value == 'card') {
        method_card.style.display = 'block';
        method_mbway.style.display = 'none';
      } else if (element.value == 'mbway') {
        method_card.style.display = 'none';
        method_mbway.style.display = 'block';
      }
    });
  });
}
catch (error) {}
