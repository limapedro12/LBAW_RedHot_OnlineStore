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
                            <div class="adminSideBarOptionSubOption" id="optionNotSelected">
                                <p>Destaques</p>
                            </div>
                        </a>

                        <a href="{{ url('/adminProductsAdd') }}">
                            <div class="adminSideBarOptionSubOption" id="optionSelected">
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

                <h1>Adicionar Novo Produto</h1>

                <form action="/products/add" method="POST" enctype="multipart/form-data">
                    @csrf

                    <label for="name">Nome:</label>
                    <input type="text" id="name" name="name" required><br><br>

                    <label for="price">Preço:</label>
                    <input type="number" step="0.01" id="price" name="price" required><br><br>

                    <label for="discount">Desconto:</label>
                    <input type="number" step="0.001" id="discount" name="discount"><br><br>

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

            </div>
        </div>
    </div>
@endsection
