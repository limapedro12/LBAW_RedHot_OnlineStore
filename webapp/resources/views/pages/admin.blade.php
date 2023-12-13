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
                        <div class="adminSideBarOption" id="optionSelected">
                            <div id="rectangle"></div>
                            <p>Estatísticas</p>
                        </div>
                    </a>

                    <a href="{{ url('/adminOrders') }}">
                        <div class="adminSideBarOption" id="optionNotSelected">
                            <p>Encomendas</p>
                        </div>
                    </a>

                    <a href="{{ url('/adminProductsManage') }}">
                        <div class="adminSideBarOption" id="optionNotSelected">
                            <p>Produtos</p>
                            <i class="fas fa-angle-down"></i>
                        </div>
                    </a>
                    <!--
                        <div class="adminSideBarOptionSubOptions">
                            <a href="{{ url('/adminProductsManage') }}">
                                <div class="adminSideBarOptionSubOption" id="optionNotSelected">
                                    <p>Gerir</p>
                                </div>
                            </a>

                            <a href="{{ url('/adminProductsHighlights') }}">
                                <div class="adminSideBarOptionSubOption" id="optionNotSelected">
                                    <p>Destaques</p>
                                </div>
                            </a>

                            <a href="{{ url('/adminProductsDiscounts') }}">
                                <div class="adminSideBarOptionSubOption" id="optionNotSelected">
                                    <p>Descontos</p>
                                </div>
                            </a>
                        </div>
                    -->
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
                <h2>Estatísticas de Vendas</h2>
                <h3>Total de Vendas: {{ $sales['count'] }}</h3>
                <h3>Total Faturado: {{ $sales['total'] }}€</h3>
                <h3>Valor médio por encomenda: {{ $sales['avg'] }}€</h3>
            </div>
        </div>
    </div>
@endsection
