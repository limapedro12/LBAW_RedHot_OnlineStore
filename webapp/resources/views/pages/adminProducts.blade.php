@extends('layouts.adminHeaderFooter')

@section('content')
    <div class="adminPage">
        <h1>Admin Dashboard</h1>
        
        <div class="adminSideBar">
            <h2>Admin Side Bar</h2>
            <p>Admin side bar goes here</p>
            <div class="adminSearchBarOnSideBar">
                <form action="#" method="post">
                    <input type="text" placeholder="Search..">
                    <button type="submit"><i class="fa fa-search"></i></button>
                </form>
            </div>
            <div class="adminSideBarOptions">
                <div class="adminSideBarOption" id="optionNotSelected">
                    <a class="adminSideBarOptionSelected" href="{{ url('/admin') }}">Estatísticas</a>
                </div>
                <div class="adminSideBarOption" id="optionNotSelected">
                    <a href="{{ url('/adminOrders') }}">Encomendas</a>
                </div>
                <div class="adminSideBarOption" id="optionSelected">
                    <a href="{{ url('/adminProducts') }}">Produtos <i class="fas fa-angle-up"></i></a>
                    <div class="adminSideBarOptionSubOptions">
                        <div class="adminSideBarOptionSubOption" id="subOptionNotSelected">
                            <a href="{{ url('/adminProductsManage') }}">Gerir</a>
                        </div>
                        <div class="adminSideBarOptionSubOption" id="subOptionNotSelected">
                            <a href="{{ url('/adminProductsHighlights') }}">Destaques</a>
                        </div>
                        <div class="adminSideBarOptionSubOption" id="subOptionNotSelected">
                            <a href="{{ url('/adminProductsDiscounts') }}">Descontos</a>
                        </div>
                    </div>
                </div>
                <div class="adminSideBarOption" id="optionNotSelected">
                    <a href="{{ url('/adminShipping') }}">Entregas</a>
                </div>
                <div class="adminSideBarOption" id="optionNotSelected">
                    <a href="{{ url('/adminUsers') }}">Utilizadores</a>
                </div>
        </div>
        <div class="adminOptionContent">
            <h2>Admin Content</h2>
            <p>Admin content goes here</p>
        </div>
    </div>
@endsection
