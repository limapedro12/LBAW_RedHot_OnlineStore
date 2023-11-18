document.querySelector('.search').addEventListener('submit', function(event) {
    event.preventDefault();
    var searchString = document.getElementById('searchedString').value;
    window.location.href = '/products/search/' + encodeURIComponent(searchString);
});
