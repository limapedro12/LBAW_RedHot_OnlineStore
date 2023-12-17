<head>
    <title>Produtos em Destaque | RedHot</title>
</head>

@extends('layouts.adminHeaderFooter')

@section('content')
    <div class="adminContent">
        <div class="adminPage">
            <div class="adminSideBar">
                <div class="adminSearchBarOnSideBar">
                    <form action="#" method="post">
                        <input type="text" placeholder="Produto..">
                        <button type="submit"><i class="fa fa-search"></i></button>
                    </form>
                </div>
                <div class="adminSideBarOptions">
                    <a href="{{ url('/admin') }}">
                        <div class="adminSideBarOption" id="optionNotSelected">
                            <p>Estatísticas</p>
                        </div>
                    </a>

                    <a href="{{ url('/adminOrders') }}">
                        <div class="adminSideBarOption" id="optionNotSelected">
                            <p>Encomendas</p>
                        </div>
                    </a>

                    <a href="{{ url('/adminProductsManage') }}">
                        <div class="adminSideBarOption" id="optionSelected">
                            <div id="rectangle"></div>
                            <p>Produtos </p>
                            <i class="fas fa-angle-up"></i>
                        </div>
                    </a>

                    <div class="adminSideBarOptionSubOptions">
                        <a href="{{ url('/adminProductsManage') }}">
                            <div class="adminSideBarOptionSubOption" id="optionNotSelected">
                                <p>Gerir</p>
                            </div>
                        </a>

                        <a href="{{ url('/adminProductsHighlights') }}">
                            <div class="adminSideBarOptionSubOption" id="optionSelected">
                                <p>Destaques</p>
                            </div>
                        </a>

                        <a href="{{ url('/adminProductsAdd') }}">
                            <div class="adminSideBarOptionSubOption" id="optionNotSelected">
                                <p>Adicionar</p>
                            </div>
                        </a>
                    </div>

                    <a href="{{ url('/adminUsers') }}">
                        <div class="adminSideBarOption" id="optionNotSelected">
                            <p>Utilizadores</p>
                        </div>
                    </a>

                    <a href="{{ url('/adminFAQ') }}">
                        <div class="adminSideBarOption" id="optionNotSelected">
                            <p>FAQ's</p>
                        </div>
                    </a>
                </div>
            </div>
            <div class="adminOptionContent">

                <div class="adminOptionContentTitle">
                    <h1>Gestão de Destaques</h1>
                </div>

                <div class="adminHighlightContent">
                    <div class="adminHighlightContentTitle">
                        <h2>Produtos em Destaque</h2>
                    </div>
                    @if ($destaques->count() == 0)
                        <div class="highlightsEmpty">
                            <div class="highlightsEmptyImg">
                                <img src="{{ asset('sources/wishlist/empty-wishlist.png') }}" alt="Wishlist Vazia">
                            </div>
                            <div class="highlightsEmptyText">
                                <h3>Não existem produtos em destaque.</h3>
                            </div>
                        </div>
                    @else
                        <div class="productsPageProducts" id='listOfProducts'>
                            @foreach ($destaques as $product)
                            <div class="highlightProductListItem">
                                <div class="productListItem">
                                    <div class="productListItemImg">
                                        <a href = "/products/{{ $product->id }}">
                                            <img src="{{ $product->getProductImage() }}"
                                                alt="Imagem de {{ $product->nome }}" width="100px" height="100px">
                                        </a>
                                    </div>
                                    <div class="productListItemTitle">
                                        <a href = "/products/{{ $product->id }}">
                                            <h3>
                                                {{ $product->nome }}
                                            </h3>
                                        </a>
                                    </div>
                                    <div class="productListItemBottom">
                                        <div class="productListItemRating">
                                            <div class="productListItemNumberOfReviews">
                                                <p> {{ $product->getProductNumberOfReviews() }} avaliações </p>
                                            </div>
                                            <div class="productListItemHearts">
                                                <p> {{ $product->getProductRating() }}/ 5 <i class="fa-solid fa-heart"></i>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="productListItemPrices">
                                            @if ($product->desconto > 0)
                                                <div class="productListItemOldPrice">
                                                    <p class="discount">
                                                        {{ $product->desconto * 100 }}%
                                                    </p>
                                                    <p class="oldPrices">
                                                        {{ $product->precoatual }}
                                                    </p>
                                                    <p class="euro">€ </p>
                                                </div>
                                                <div class="productListItemNewPrice">
                                                    <p class="newPrices">
                                                        {{ round($discountFunction($product->precoatual, $product->desconto), 2) }}
                                                        €
                                                    </p>
                                                </div>
                                            @else
                                                <div class="productListItemPrice">
                                                    <p class="Price">
                                                        {{ $product->precoatual }}€
                                                    </p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                                <div class="removeHighlight">
                                    <form action="{{ route('removeHighlight', ['id' => $product->id]) }}" method="post">
                                        @csrf
                                        <button type="submit">Remover dos Destaques</button>
                                    </form>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @if ($destaques->count() == 4)
                            <div class="maxHighlights">
                                <p>Foram atingidos o máximo de destaques.</p>
                            </div>
                        @endif
                    @endif
                </div>


                <div class="adminHighlightContent">
                    <div class="adminHighlightContentTitle">
                        <h2>Restantes Produtos</h2>
                    </div>

                    <div class="tableOrders">
                        <div class="profileOrders">

                            <div class="topOfTable">
                                <div class="filterTable">
                                    <input type="text" id="filterInput" placeholder="Pesquisar..."
                                        title="Filtrar Tabela">
                                </div>
                            </div>

                            <div class="myOrdersTable">
                                <div class="myOrdersTableBody">
                                    <table class="tableSortable" id="tableToFilter">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Imagem</th>
                                                <th>Nome</th>
                                                <th>Stock</th>
                                                <th>Desconto</th>
                                                <th>Preço</th>
                                                @if ($destaques->count() < 4)
                                                    <th>Adicionar aos Destaques</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($restantesProdutos as $product)
                                                <tr>
                                                    <td>
                                                        <div class="myProductID">
                                                            <p>
                                                                <a href='/products/{{ $product->id }}'>
                                                                    {{ $product->getNormalizeOrderId($product->id) }}
                                                                </a>
                                                            </p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="myProductImage">
                                                            <a href='/products/{{ $product->id }}'>
                                                                <img src="{{ $product->getProductImage() }}"
                                                                    alt="Imagem de {{ $product->nome }}" width="50px"
                                                                    height="50px">
                                                            </a>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="myProductName">
                                                            <p>
                                                                <a href='/products/{{ $product->id }}'>
                                                                    {{ $product->nome }}
                                                                </a>
                                                            </p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="myProductStock">
                                                            <p>
                                                                {{ $product->stock }}
                                                            </p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="myProductDiscount">
                                                            <p>
                                                                {{ $product->desconto * 100 }}%
                                                            </p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="myProductPrice">
                                                            <p>
                                                                {{ $product->precoatual }}€
                                                            </p>
                                                        </div>
                                                    </td>
                                                    @if ($destaques->count() < 4)
                                                        <td>
                                                            <div class="myProductAddToHighlights">
                                                                <form
                                                                    action="{{ route('addHighlight', ['id' => $product->id]) }}"
                                                                    method="post">
                                                                    @csrf
                                                                    <button type="submit"><i class="fa-solid fa-plus"></i></button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
