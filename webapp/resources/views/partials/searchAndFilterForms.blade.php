<script src="{{ asset('js/app.js') }}" defer></script>
<form id="searchAndFilter">
    <!-- Search -->
    <label for="searchedString">Pesquisa:</label>
    <input type="text" name="searchedString" id="searchedString">
    <br>

    <!-- Filter -->
    <label> Filtros: </label>
    <label>Preco:</label>
    <input type="text" name="priceFilterMin" id="priceFilterMin" placeholder="Min">
    <input type="text" name="priceFilterMax" id="priceFilterMax" placeholder="Max">
    <label>Desconto:</label>
    <input type="checkbox" name="discountFilter" id="discountFilter">
    <input type="text" name="discountFilterMin" id="discountFilterMin" placeholder="Min">
    <input type="text" name="discountFilterMax" id="discountFilterMax" placeholder="Max">
    <label>Stock:</label>
    <input type="text" name="stockFilterMin" id="stockFilterMin" placeholder="Min">
    <input type="text" name="stockFilterMax" id="stockFilterMax" placeholder="Max">
    <label> Categoria: </label>
    <input type="text" name="category" id="category" placeholder="Categoria">
    <input type="submit" value="Pesquisar">
</form>
