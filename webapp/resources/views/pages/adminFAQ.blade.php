<head>
    <title>Gestão de FAQ's | RedHot</title>
</head>

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

                    <a href="{{ url('/adminFAQ') }}">
                        <div class="adminSideBarOption" id="optionSelected">
                            <div id="rectangle"></div>
                            <p>FAQ's</p>
                        </div>
                    </a>
                </div>
            </div>

            <div class="adminOptionContent">

                <section>
                    <div class="faqs">
                        <h1>Perguntas Frequentes</h1>

                        <div class="adminFAQButtons">
                            <form method="GET" action="{{ route('addFaqForm') }}">
                                @csrf
                                <button type="submit" class="adminFAQButton">Adicionar FAQ</button>
                            </form>
                        </div>

                        <div>
                            <table class="faqs">
                                @foreach ($faqs as $faq)
                                    <tr>
                                        <th>{{ $faq->pergunta }}</th>
                                        <td>
                                            <form method="POST" action="{{ route('deleteFaqs', ['id' => $faq->id]) }}">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="adminFAQButton"><i
                                                        class="fas fa-trash-alt"></i></button>
                                            </form>
                                        </td>

                                        <td>
                                            <form method="GET" action="{{ route('faq', ['id' => $faq->id]) }}">
                                                @csrf
                                                <button type="submit" class="adminFAQButton"><i
                                                        class="fas fa-edit"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </section>

            </div>

        </div>
    </div>
@endsection
