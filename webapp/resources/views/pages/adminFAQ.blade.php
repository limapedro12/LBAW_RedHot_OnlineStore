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
                        <div class="faqsTitle">
                            <h1>Perguntas Frequentes</h1>
                        </div>

                        <div class="faqsDisplay">
                            @foreach ($faqs as $faq)
                                <div class="faq">
                                    <div class="faqQuestion">
                                        <h2>{{ $faq->pergunta }}</h2>
                                        <span class="faqArrow"><i class="fas fa-sort-down"></i></span>
                                    </div>
                                    <div class="faqAnswer">
                                        <p>{{ $faq->resposta }}</p>
                                    </div>
                                    <div class="adminFAQButtons">
                                        <button class="adminFAQButton"><i class="fas fa-edit"></i></button>
                                        <button class="adminFAQButton"><i class="fas fa-trash-alt"></i></button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>            
            </div>   
                
            </div>
        </div>
    </div>
@endsection
