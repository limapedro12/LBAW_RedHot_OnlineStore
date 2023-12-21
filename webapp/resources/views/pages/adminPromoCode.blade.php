@extends('layouts.adminHeaderFooter')

@section('title', "Gestão de Códigos Promocionais |")

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

                    <a href="{{ url('/adminPromoCode')}}">
                        <div class="adminSideBarOption" id="optionSelected">
                            <div id="rectangle"></div>
                            <p>Códigos Promocionais</p>
                            <i class="fas fa-angle-up"></i>
                        </div>
                    </a>
                    <div class="adminSideBarOptionSubOptions">
                        <a href="{{ url('/adminPromoCode') }}">
                            <div class="adminSideBarOptionSubOption" id="optionSelected">
                                <p>Gerir</p>
                            </div>
                        </a>

                        <a href="{{ url('/adminPromoCodeAdd') }}">
                            <div class="adminSideBarOptionSubOption" id="optionNotSelected">
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
                    <h1>Códigos Promocionais</h1>
                </div>

                <div class="adminOrderContent">
                    <div class="tableOrders">
                        <div class="profileOrders">

                            <div class="topOfTable">
                                <div class="faqTopTable">
                                    <div class="filterTable">
                                        <input type="text" id="filterInput" placeholder="Pesquisar..."
                                            title="Filtrar Tabela">
                                    </div>
                                </div>
                            </div>

                            <div class="myOrdersTable">
                                <div class="myOrdersTableBody">
                                @if ($errors->has('ban'))
                                    <p class="text-danger">
                                        {{ $errors->first('ban') }}
                                    </p>
                                @endif
                                @if ($errors->has('promote'))
                                    <p class="text-danger">
                                        {{ $errors->first('promote') }}
                                    </p>
                                @endif
                                    <table class="tableSortable" id="tableToFilter">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Código</th>
                                                <th>Desconto</th>
                                                <th>Data de Inicio</th>
                                                <th>Data de Fim</th>
                                                <th>Editar</th>
                                                <th>Remover</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($promoCodes as $promoCode)
                                                <tr>
                                                    <td>
                                                        <div class="myOrderID">
                                                            <p>
                                                                {{ $promoCode->getNormalizePromoCodeId($promoCode->id) }}
                                                            </p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="myOrderDate">
                                                            <p>{{ $promoCode->codigo }}</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="myOrderDate">
                                                            <p>{{ $promoCode->desconto * 100 }}%</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="myOrderDate">
                                                            <p>{{ $promoCode->data_inicio }}</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="myOrderDate">
                                                            <p>{{ $promoCode->data_fim }}</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="faqButtons">
                                                            <form method="GET"
                                                                action="{{ route('promo_codes.edit', ['id' => $promoCode->id]) }}">
                                                                @csrf
                                                                <button type="submit" class="adminFAQButton">
                                                                    <i class="fas fa-edit"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="faqButtons">
                                                            <form method="POST"
                                                                action="{{ route('promo_codes.delete', ['id' => $promoCode->id]) }}">
                                                                @csrf
                                                                @method('delete')
                                                                <button type="submit" class="adminFAQButton">
                                                                    <i class="fas fa-trash-alt"></i>
                                                                </button>
                                                            </form>
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
