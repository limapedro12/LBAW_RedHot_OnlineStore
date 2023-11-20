@extends('layouts.adminHeaderFooter')

@section('content')
    <div class="adminPage">      
        <div class="adminSideBar">
            <div class="adminSearchBarOnSideBar">
                <form action="#" method="post">
                    <input type="text" placeholder="Produto..">
                    <button type="submit"><i class="fa fa-search"></i></button>
                </form>
            </div>
            <div class="adminSideBarOptions">
                <div class="adminSideBarOption" id="optionSelected">
                    <a class="adminSideBarOptionSelected" href="{{ url('/admin') }}">Estatísticas</a>
                </div>
                <div class="adminSideBarOption" id="optionNotSelected">
                    <a href="{{ url('/adminOrders') }}">Encomendas</a>
                </div>
                <div class="adminSideBarOption" id="optionNotSelected">
                    <a href="{{ url('/adminProducts') }}">Produtos <i class="fas fa-angle-down"></i></a>
                    <!--<div class="adminSideBarOptionSubOptions">
                        <div class="adminSideBarOptionSubOption" id="subOptionNotSelected">
                            <a href="{{ url('/adminProductsManage') }}">Gerir</a>
                        </div>
                        <div class="adminSideBarOptionSubOption" id="subOptionNotSelected">
                            <a href="{{ url('/adminProductsHighlights') }}">Destaques</a>
                        </div>
                        <div class="adminSideBarOptionSubOption" id="subOptionNotSelected">
                            <a href="{{ url('/adminProductsDiscounts') }}">Descontos</a>
                        </div>
                    </div>-->
                </div>
                <div class="adminSideBarOption" id="optionNotSelected">
                    <a href="{{ url('/adminShipping') }}">Entregas</a>
                </div>
                <div class="adminSideBarOption" id="optionNotSelected">
                    <a href="{{ url('/adminUsers') }}">Utilizadores</a>
                </div>
            </div>
        </div>
        <div class="adminOptionContent">
            <h2>Admin Content</h2>
            <p>Admin content goes here</p>
        </div>
    </div>
@endsection
