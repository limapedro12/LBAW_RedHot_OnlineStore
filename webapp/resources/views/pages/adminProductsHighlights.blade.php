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

                        <a href="{{ url('/adminProductsAdd') }}">
                            <div class="adminSideBarOptionSubOption" id="optionNotSelected">
                                <p>Adicionar</p>
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

                @if ($destaques->count() == 0)
                    <p>Não existem produtos em destaque.</p>
                @endif
                
                <div class="productsPageProducts" id='listOfProducts'>
                    @foreach ($destaques as $product)
                        <div class="productListItem">
                            <div class="productListItemImg">
                                <a href = "/products/{{ $product->id }}">
                                    <img src="{{ $product->getProductImage() }}" alt="Imagem de {{ $product->nome }}" width="100px" height="100px">
                                </a>
                            </div>
                            <div class="productListItemTitle">
                                <a href = "/products/{{ $product->id }}">
                                    <h3>
                                        {{ $product->nome }}
                                    </h3>
                                </a>
                            </div>
                            <div class="productListItemBottom">
                                <div class="productListItemRating">
                                    <div class="productListItemNumberOfReviews">
                                        <p> 723 {{ $product->avaliacao }} avaliações </p>
                                    </div>
                                    <div class="productListItemHearts">
                                        <p> 4.3 {{ $product->avaliacao }}/ 5 <i class="fa-solid fa-heart"></i> </p>
                                    </div>
                                </div>
                                <div class="productListItemPrices">
                                    @if ($product->desconto > 0)
                                        <div class="productListItemOldPrice">
                                            <p class="discount">
                                                {{ $product->desconto * 100 }}%
                                            </p>
                                            <p class="oldPrices">
                                                {{ $product->precoatual }}
                                            </p>
                                            <p class="euro">€ </p>
                                        </div>
                                        <div class="productListItemNewPrice">
                                            <p class="newPrices">
                                                {{ round($discountFunction($product->precoatual, $product->desconto), 2) }} €
                                            </p>
                                        </div>
                                    @else
                                        <div class="productListItemPrice">
                                            <p class="Price">
                                                {{ $product->precoatual }}€
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <form action="{{ route('removeHighlight', ['id' => $product->id]) }}" method="post">
                                @csrf
                                <button type="submit">Remover dos Destaques</button>
                            </form>

                        </div>
                    @endforeach

                    @if ($destaques->count() == 4)
                        <p>Atingido o número máximo de produtos em destaque</p>
                    @endif
                </div>

                <h2>Restantes Produtos</h2>

                <div class="productsPageProducts" id='listOfProducts'>
                    @foreach ($restantesProdutos as $product)
                        <div class="productListItem">
                            <div class="productListItemImg">
                                <a href = "/products/{{ $product->id }}">
                                    <img src="{{ $product->getProductImage() }}" alt="Imagem de {{ $product->nome }}" width="100px" height="100px">
                                </a>
                            </div>
                            <div class="productListItemTitle">
                                <a href = "/products/{{ $product->id }}">
                                    <h3>
                                        {{ $product->nome }}
                                    </h3>
                                </a>
                            </div>
                            <div class="productListItemBottom">
                                <div class="productListItemRating">
                                    <div class="productListItemNumberOfReviews">
                                        <p> 723 {{ $product->avaliacao }} avaliações </p>
                                    </div>
                                    <div class="productListItemHearts">
                                        <p> 4.3 {{ $product->avaliacao }}/ 5 <i class="fa-solid fa-heart"></i> </p>
                                    </div>
                                </div>
                                <div class="productListItemPrices">
                                    @if ($product->desconto > 0)
                                        <div class="productListItemOldPrice">
                                            <p class="discount">
                                                {{ $product->desconto * 100 }}%
                                            </p>
                                            <p class="oldPrices">
                                                {{ $product->precoatual }}
                                            </p>
                                            <p class="euro">€ </p>
                                        </div>
                                        <div class="productListItemNewPrice">
                                            <p class="newPrices">
                                                {{ round($discountFunction($product->precoatual, $product->desconto), 2) }} €
                                            </p>
                                        </div>
                                    @else
                                        <div class="productListItemPrice">
                                            <p class="Price">
                                                {{ $product->precoatual }}€
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            @if ($destaques->count() < 4)                               
                                <form action="{{ route('addHighlight', ['id' => $product->id]) }}" method="post">
                                    @csrf
                                    <button type="submit">Adicionar aos Destaques</button>
                                </form>
                            @endif

                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
