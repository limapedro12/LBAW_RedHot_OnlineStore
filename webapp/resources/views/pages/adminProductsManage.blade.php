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
                        <div class="adminSideBarOptionSubOption" id="optionSelected">
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

            <h2>Gestão de Produtos</h2>
            <section>
                <h1>Adicionar Novo Produto</h1>
            
                <form id="addProductForm" method="POST" action="{{ route('addProduct') }}" enctype="multipart/form-data">
                    @csrf
            
                    <label for="name">Nome:</label>
                    <input type="text" id="name" name="name" required><br><br>
            
                    <label for="price">Preco:</label>
                    <input type="number" step="0.01" id="price" name="price" required><br><br>
            
                    <label for="discount">Desconto:</label>
                    <input type="number" step="0.001" id="discount" name="discount" required><br><br>
            
                    <label for="stock">Stock:</label>
                    <input type="number" id="stock" name="stock" required><br><br>
            
                    <label for="description">Descrição:</label>
                    <textarea id="description" name="description" required></textarea><br><br>
            
                    <label for="file">Imagem:</label>
                    <input type="file" id="file" name="file"><br><br>
            
                    <label for="category">Categoria:</label>
                    <input type="text" id="category" name="category"><br><br>
            
                    <input type="submit" value="Adicionar Produto">
                </form>
            </section>
            <section>
                <h1>Lista de Produtos</h1>
                <div id='listOfProducts'>
                    @foreach ($products as $product) 
                        <section class="productListItem">
                            <img src="{{ $product->getProductImage() }}" alt="Imagem de {{ $product->nome }}" height = "100">
                            <h4> <a href = "/products/{{ $product->id }}"> {{ $product->nome }} </a> </h4> 
                            <p> 
                                @if($product->desconto > 0)
                                    <span style = "text-decoration: line-through;">
                                        {{ $product->precoatual }}
                                    </span>&nbsp
                                @endif
                                {{ round($discountFunction($product->precoatual, $product->desconto),2) }} €
                            </p>
                            @if($product->desconto > 0)
                            <p> Desconto: {{ $product->desconto * 100 }}% </p>
                            @endif
                            <p> Categoria: {{ $product->categoria }} </p>
                            <br>

                            <form method="GET" action="{{ route('editProduct', ['id' => $product->id]) }}">
                                <input type="submit" value="Editar informações">
                            </form>

                        </section>
                    @endforeach
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
