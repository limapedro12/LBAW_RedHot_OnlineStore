@extends('layouts.adminHeaderFooter')

@section('content')
<<<<<<< 6537656d576cc99e341cc4a1b000a8ffcafb9c79
<div class="adminContent">
=======
    {{ Auth::guard('admin')->user()->nome }}
>>>>>>> 16adcb487aaf964401f5d6d5ab52c8c004817c28
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

                <a href="{{ url('/adminProducts') }}">
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
                <a href="{{ url('/adminShipping') }}">
                    <div class="adminSideBarOption" id="optionNotSelected">
                        <p>Entregas</p>
                    </div>
                </a>

                <a href="{{ url('/adminUsers') }}">
                    <div class="adminSideBarOption" id="optionNotSelected">
                        <p>Utilizadores</p>
                    </div>
                </a>
            </div>
        </div>
        <div class="adminOptionContent">
            <h2>Admin Content</h2>
            <p>Admin content goes here</p>
        </div>
    </div>
</div>
@endsection
