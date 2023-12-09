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

                    <a href="{{ url('/adminProducts') }}">
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

                        <a href="{{ url('/adminProductsDiscounts') }}">
                            <div class="adminSideBarOptionSubOption" id="optionNotSelected">
                                <p>Descontos</p>
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
                <h2>Produtos em Destaque</h2>
                <div class='mainDestaques'>
                    <div class='top4SellingProducts'>
                        <div class='top4SellingProductsList'>
                            <a href="{{ url('/products/1') }}">
                                <div class='top4SellingProductsItem'>
                                    <div class='top4SellingProductsItemImg'>
                                        <img src="{{ asset('sources/main/sacana_extra_picante_75ml.png') }}"
                                            alt="Produto 1">
                                    </div>
                                    <div class='top4SellingProductsItemInfo'>
                                        <h3>Produto 1</h3>
                                        <p>Avaliação: 5</p>
                                        <p>Preço: 10€</p>
                                    </div>
                                </div>
                            </a>
                            <a href="{{ url('/products/2') }}">
                                <div class='top4SellingProductsItem'>
                                    <div class='top4SellingProductsItemImg'>
                                        <img src="{{ asset('sources/main/sacana_extra_picante_75ml.png') }}"
                                            alt="Produto 2">
                                    </div>
                                    <div class='top4SellingProductsItemInfo'>
                                        <h3>Produto 2</h3>
                                        <p>Avaliação: 4.9</p>
                                        <p>Preço: 10€</p>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
