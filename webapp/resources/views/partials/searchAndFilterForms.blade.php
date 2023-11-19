<script src="{{ asset('js/searchAndFilter.js') }}" defer></script>
<form id="searchAndFilter">
    <!-- Search -->
    <label for="searchedString">Pesquisa:</label>
    <input type="text" name="searchedString" id="searchedString" value='{{ $searchedString }}'>
    <br>

    <!-- Filter -->
    <label> Filtros: </label>
    <label>Preco:</label>
    <input type="text" name="priceFilterMin" id="priceFilterMin" placeholder="Min" value='{{ $filterPriceMin }}'>
    <input type="text" name="priceFilterMax" id="priceFilterMax" placeholder="Max" value='{{ $filterPriceMax }}'>
    <label>Desconto:</label>
    @if($filterDiscount)
        <input type="checkbox" name="discountFilter" id="discountFilter" checked>
    @else
        <input type="checkbox" name="discountFilter" id="discountFilter">
    @endif
    <input type="text" name="discountFilterMin" id="discountFilterMin" placeholder="Min" value='{{ $filterDiscountMin }}'>
    <input type="text" name="discountFilterMax" id="discountFilterMax" placeholder="Max" value='{{ $filterDiscountMax }}'>
    <label>Stock:</label>
    <input type="text" name="stockFilterMin" id="stockFilterMin" placeholder="Min" value='{{ $filterStockMin }}'>
    <input type="text" name="stockFilterMax" id="stockFilterMax" placeholder="Max" value='{{ $filterStockMax }}'>
    <input type="submit" value="Pesquisar">
</form>
