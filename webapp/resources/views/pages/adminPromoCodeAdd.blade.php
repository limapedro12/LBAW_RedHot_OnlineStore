@extends('layouts.adminHeaderFooter')

@section('title', 'Gestão de Códigos Promocionais |')

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

                    <a href="{{ url('/adminPromoCode') }}">
                        <div class="adminSideBarOption" id="optionSelected">
                            <div id="rectangle"></div>
                            <p>Códigos Promocionais</p>
                            <i class="fas fa-angle-up"></i>
                        </div>
                    </a>
                    <div class="adminSideBarOptionSubOptions">
                        <a href="{{ url('/adminPromoCode') }}">
                            <div class="adminSideBarOptionSubOption" id="optionNotSelected">
                                <p>Gerir</p>
                            </div>
                        </a>

                        <a href="{{ url('/adminPromoCodeAdd') }}">
                            <div class="adminSideBarOptionSubOption" id="optionSelected">
                                <p>Adicionar</p>
                            </div>
                        </a>
                    </div>

                    <a href="{{ url('/adminFAQ') }}">
                        <div class="adminSideBarOption" id="optionNotSelected">
                            <p>FAQ's</p>
                        </div>
                    </a>
                </div>
            </div>

            <div class="adminOptionContent">
                <div class="adminOptionContentTitle">
                    <h1>Adicionar Novo Código Promocional</h1>
                </div>

                <div class="adminHighlightContent">
                    <div class="adminAddForm">
                        <div class="adminHighlightContentTitle">
                            <h2>Informação</h2>
                        </div>
                        <div class="adminAddProductForm">
                            <form action="{{ route('promo_codes.create') }}" method="POST" class="addPromoCodeForm">
                                @csrf

                                <div class="inputBox">
                                    <div class="adminAddProduct">
                                        <label for="codigo">Código:</label>
                                        <input type="text" id="codigo" name="codigo" required>
                                    </div>
                                    @if ($errors->has('codigo'))
                                        <p class="text-danger">
                                            {{ $errors->first('codigo') }}
                                        </p>
                                    @endif
                                </div>


                                <div class="inputBoxSpecial">
                                    <div class="adminAddProduct">
                                        <label for="data_inicio">Data de Inicio:</label>
                                        <input type="date" id="data_inicio" name="data_inicio" value="2023-07-22"
                                            min="2022-01-01" max="2025-12-31" required>
                                        <input type="time" id="tempo_inicio" name="tempo_inicio" min="00:00"
                                            max="23:59" required>
                                    </div>
                                    <div class="adminAddProduct">
                                        <label for="data_fim">Data de Fim:</label>
                                        <input type="date" id="data_fim" name="data_fim" value="2023-07-22"
                                            min="2022-01-01" max="2025-12-31" required>
                                        <input type="time" id="tempo_fim" name="tempo_fim" min="00:00" max="23:59"
                                            required>
                                    </div>
                                </div>

                                <div class="inputBoxSpecial">
                                    <div class="adminAddProduct">
                                        <label for="discount">Desconto:</label>
                                        <input type="number" step="1" id="discount" min="1" max="100"
                                            name="discount" required>
                                    </div>
                                </div>

                                <div class="addProductButton">
                                    <input type="submit" value="Adicionar Promo Code">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
