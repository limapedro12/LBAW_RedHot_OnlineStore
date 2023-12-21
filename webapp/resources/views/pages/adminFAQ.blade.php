@extends('layouts.adminHeaderFooter')

@section('title', "Gestão de FAQ's |")

@section('content')
    <div class="adminContent">
        <div class="adminPage">
            <div class="adminSideBar">
                <div class="adminSearchBarOnSideBar">
                    <form action="{{ route('searchProductById') }}" method="post">
                        @csrf
                        <input type="text" id="id" placeholder="Produto..">
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
                        <div class="adminSideBarOption" id="optionNotSelected">
                            <p>Códigos Promocionais</p>
                            <i class="fas fa-angle-down"></i>
                        </div>
                    </a>

                    <a href="{{ url('/adminFAQ') }}">
                        <div class="adminSideBarOption" id="optionSelected">
                            <div id="rectangle"></div>
                            <p>FAQ's</p>
                        </div>
                    </a>
                </div>
            </div>

            <div class="adminOptionContent">
                <div class="adminOptionContentTitle">
                    <h1>Perguntas Frequentes</h1>
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
                                    <div class="adminFAQButtons">
                                        <form method="GET" action="{{ route('addFaqForm') }}">
                                            @csrf
                                            <button type="submit" class="adminFAQButton">Adicionar FAQ</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="myOrdersTable">
                                <div class="myOrdersTableBody">
                                    <table class="tableSortable" id="tableToFilter">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Pergunta</th>
                                                <th>Editar</th>
                                                <th>Apagar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($faqs as $faq)
                                                <tr>
                                                    <td>
                                                        <div class="myOrderID">
                                                            <p>
                                                                {{ $faq->getNormalizeFaqId($faq->id) }}
                                                            </p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="myOrderDate">
                                                            <p>
                                                                {{ $faq->pergunta }}
                                                            </p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="faqButtons">
                                                            <form method="GET"
                                                                action="{{ route('faq', ['id' => $faq->id]) }}">
                                                                @csrf
                                                                <button type="submit" class="adminFAQButton"><i
                                                                        class="fas fa-edit"></i></button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="faqButtons">
                                                            <form method="POST"
                                                                action="{{ route('deleteFaqs', ['id' => $faq->id]) }}">
                                                                @csrf
                                                                @method('delete')
                                                                <button type="submit" class="adminFAQButton"><i
                                                                        class="fas fa-trash-alt"></i></button>
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
