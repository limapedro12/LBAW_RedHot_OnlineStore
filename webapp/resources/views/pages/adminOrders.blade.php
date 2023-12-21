@extends('layouts.adminHeaderFooter')

@section('title', 'Gestão de Encomendas |')

@section('content')
    <div class="adminContent">
        <div class="adminPage">
            <div class="adminSideBar">
                <div class="adminSearchBarOnSideBar">
                    <form action="{{ route('searchProductById') }}" method="post">
                        @csrf
                        <input type="text" id="id" name="id" placeholder="Produto..">
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
                        <div class="adminSideBarOption" id="optionSelected">
                            <div id="rectangle"></div>
                            <p>Encomendas</p>
                        </div>
                    </a>

                    <a href="{{ url('/adminProductsManage') }}">
                        <div class="adminSideBarOption" id="optionNotSelected">
                            <p>Produtos</p>
                            <i class="fas fa-angle-down"></i>
                        </div>
                    </a>

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
                    <h1>Encomendas</h1>
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
                                                <th>Encomenda</th>
                                                <th>Data</th>
                                                <th>Estado</th>
                                                <th>Email</th>
                                                <th>Preço</th>
                                                <th>Detalhes</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orders as $order)
                                                <tr>
                                                    <td>
                                                        <div class="myOrderID">
                                                            <p>
                                                                {{ $order->getNormalizeOrderId($order->id) }}
                                                            </p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="myOrderDate">
                                                            <p>
                                                                {{ $order->timestamp }}
                                                            </p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="myOrderStatus">
                                                            <p>
                                                                {{ $order->estado }}
                                                            </p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="myOrderEmail">
                                                            <p>
                                                                {{ $order->getUserEmail($order->id_utilizador) }}
                                                            </p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="myOrderPrice">
                                                            <p>
                                                                {{ $order->total }}€
                                                            </p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="myOrderDetails">
                                                            <a
                                                                href="/users/{{ $order->id_utilizador }}/orders/{{ $order->id }}">+Info</a>
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
