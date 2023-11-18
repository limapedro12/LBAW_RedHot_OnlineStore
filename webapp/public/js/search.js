document.querySelector('.search').addEventListener('submit', function(event) {
    event.preventDefault()
    var searchString = document.getElementById('searchedString').value
    let url = String(window.location.href.toString())
    if (url.indexOf('/filter/') > -1) {
        let filter = url.substring(url.indexOf('/filter/') + 8, url.length)
        window.location.href = '/products/search/' + encodeURIComponent(searchString) + '/filter/' + filter
    } else {
        window.location.href = '/products/search/' + encodeURIComponent(searchString)
    }
});
