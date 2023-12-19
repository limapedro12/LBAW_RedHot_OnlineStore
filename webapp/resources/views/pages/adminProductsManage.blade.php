@extends('layouts.adminHeaderFooter')

@section('title', 'Gestão de Produtos |')

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
                            <div class="adminSideBarOptionSubOption" id="optionSelected">
                                <p>Gerir</p>
                            </div>
                        </a>

                        <a href="{{ url('/adminProductsHighlights') }}">
                            <div class="adminSideBarOptionSubOption" id="optionNotSelected">
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

                    <a href="{{ url('/adminPromoCode')}}">
                        <div class="adminSideBarOption" id="optionNotSelected">
                            <p>Códigos Promocionais</p>
                            <i class="fas fa-angle-down"></i>
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
                    <h1>Gestão de Produtos</h1>
                </div>

                <div class="adminOrderContent">
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
                                                <th>Editar</th>
                                                <th>Apagar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($products as $product)
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

                                                            <form action="/products/{{ $product->id }}/changeStock"
                                                                method="POST">
                                                                @csrf
                                                                <label for="stock"></label>
                                                                <input type="number" id="stock" name="stock"
                                                                    value="{{ $product->stock }}" required>
                                                                <button type="submit"><i
                                                                        class="fa-solid fa-check"></i></button>
                                                            </form>

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

                                                    <td>
                                                        <div class="myProductEdit">
                                                            <a href="{{ route('editProduct', ['id' => $product->id]) }}">
                                                                <i class="fa-solid fa-file-pen"></i>
                                                            </a>
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <div class="myProductDelete">
                                                            <a href='/products/{{ $product->id }}/delete'
                                                                id='eliminarProduto'>
                                                                <i class="fa-solid fa-trash"></i>
                                                            </a>
                                                        </div>
                                                    </td>
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
