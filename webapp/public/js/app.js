function addEventListeners() {
    let itemCheckers = document.querySelectorAll('article.card li.item input[type=checkbox]');
    [].forEach.call(itemCheckers, function(checker) {
      checker.addEventListener('change', sendItemUpdateRequest);
    });
  
    let itemCreators = document.querySelectorAll('article.card form.new_item');
    [].forEach.call(itemCreators, function(creator) {
      creator.addEventListener('submit', sendCreateItemRequest);
    });
  
    let itemDeleters = document.querySelectorAll('article.card li a.delete');
    [].forEach.call(itemDeleters, function(deleter) {
      deleter.addEventListener('click', sendDeleteItemRequest);
    });
  
    let cardDeleters = document.querySelectorAll('article.card header a.delete');
    [].forEach.call(cardDeleters, function(deleter) {
      deleter.addEventListener('click', sendDeleteCardRequest);
    });
  
    let cardCreator = document.querySelector('article.card form.new_card');
    if (cardCreator != null)
      cardCreator.addEventListener('submit', sendCreateCardRequest);

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
  
  function sendItemUpdateRequest() {
    let item = this.closest('li.item');
    let id = item.getAttribute('data-id');
    let checked = item.querySelector('input[type=checkbox]').checked;
  
    sendAjaxRequest('post', '/api/item/' + id, {done: checked}, itemUpdatedHandler);
  }
  
  function sendDeleteItemRequest() {
    let id = this.closest('li.item').getAttribute('data-id');
  
    sendAjaxRequest('delete', '/api/item/' + id, null, itemDeletedHandler);
  }
  
  function sendCreateItemRequest(event) {
    let id = this.closest('article').getAttribute('data-id');
    let description = this.querySelector('input[name=description]').value;
  
    if (description != '')
      sendAjaxRequest('put', '/api/cards/' + id, {description: description}, itemAddedHandler);
  
    event.preventDefault();
  }
  
  function sendDeleteCardRequest(event) {
    let id = this.closest('article').getAttribute('data-id');
  
    sendAjaxRequest('delete', '/api/cards/' + id, null, cardDeletedHandler);
  }
  
  function sendCreateCardRequest(event) {
    let name = this.querySelector('input[name=name]').value;
  
    if (name != '')
      sendAjaxRequest('put', '/api/cards/', {name: name}, cardAddedHandler);
  
    event.preventDefault();
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
  
  function itemUpdatedHandler() {
    let item = JSON.parse(this.responseText);
    let element = document.querySelector('li.item[data-id="' + item.id + '"]');
    let input = element.querySelector('input[type=checkbox]');
    element.checked = item.done == "true";
  }
  
  function itemAddedHandler() {
    if (this.status != 200) window.location = '/';
    let item = JSON.parse(this.responseText);
  
    // Create the new item
    let new_item = createItem(item);
  
    // Insert the new item
    let card = document.querySelector('article.card[data-id="' + item.card_id + '"]');
    let form = card.querySelector('form.new_item');
    form.previousElementSibling.append(new_item);
  
    // Reset the new item form
    form.querySelector('[type=text]').value="";
  }
  
  function itemDeletedHandler() {
    if (this.status != 200) window.location = '/';
    let item = JSON.parse(this.responseText);
    let element = document.querySelector('li.item[data-id="' + item.id + '"]');
    element.remove();
  }
  
  function cardDeletedHandler() {
    if (this.status != 200) window.location = '/';
    let card = JSON.parse(this.responseText);
    let article = document.querySelector('article.card[data-id="'+ card.id + '"]');
    article.remove();
  }
  
  function cardAddedHandler() {
    if (this.status != 200) window.location = '/';
    let card = JSON.parse(this.responseText);
  
    // Create the new card
    let new_card = createCard(card);
  
    // Reset the new card input
    let form = document.querySelector('article.card form.new_card');
    form.querySelector('[type=text]').value="";
  
    // Insert the new card
    let article = form.parentElement;
    let section = article.parentElement;
    section.insertBefore(new_card, article);
  
    // Focus on adding an item to the new card
    new_card.querySelector('[type=text]').focus();
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
  

  function createCard(card) {
    let new_card = document.createElement('article');
    new_card.classList.add('card');
    new_card.setAttribute('data-id', card.id);
    new_card.innerHTML = `
  
    <header>
      <h2><a href="cards/${card.id}">${card.name}</a></h2>
      <a href="#" class="delete">&#10761;</a>
    </header>
    <ul></ul>
    <form class="new_item">
      <input name="description" type="text">
    </form>`;
  
    let creator = new_card.querySelector('form.new_item');
    creator.addEventListener('submit', sendCreateItemRequest);
  
    let deleter = new_card.querySelector('header a.delete');
    deleter.addEventListener('click', sendDeleteCardRequest);
  
    return new_card;
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



  function createItem(item) {
    let new_item = document.createElement('li');
    new_item.classList.add('item');
    new_item.setAttribute('data-id', item.id);
    new_item.innerHTML = `
    <label>
      <input type="checkbox"> <span>${item.description}</span><a href="#" class="delete">&#10761;</a>
    </label>
    `;
  
    new_item.querySelector('input').addEventListener('change', sendItemUpdateRequest);
    new_item.querySelector('a.delete').addEventListener('click', sendDeleteItemRequest);
  
    return new_item;
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
  