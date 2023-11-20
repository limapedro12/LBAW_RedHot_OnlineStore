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
  