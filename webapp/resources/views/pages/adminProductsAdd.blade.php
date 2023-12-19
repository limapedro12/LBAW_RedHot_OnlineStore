
@extends('layouts.adminHeaderFooter')

@section('title', 'Adicionar Produto |')

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

                    <a href="{{ url('/adminPromoCode')}}">
                        <div class="adminSideBarOption" id="optionNotSelected">
                            <p>Códigos Promocionais</p>
                            <i class="fas fa-angle-down"></i>
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

                <div class="adminOptionContentTitle">
                    <h1>Adicionar Produto</h1>
                </div>

                <div class="adminHighlightContent">
                    <div class="adminAddForm">
                        <div class="adminHighlightContentTitle">
                            <h2>Informação</h2>
                        </div>
                        <div class="adminAddProductForm">
                            <form action="/products/add" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="inputBox">
                                    <div class="adminAddProduct">
                                        <label for="name">Nome:</label>
                                        <input type="text" id="name" name="name" required>
                                    </div>
                                </div>


                                <div class="inputBox">
                                    <div class="adminAddProduct">
                                        <label for="category">Categoria:</label>
                                        <input type="text" id="category" name="category" required>
                                    </div>
                                </div>

                                <div class="inputBox">
                                    <div class="adminAddProduct">
                                        <label for="description">Descrição:</label>
                                        <textarea id="description" name="description" required></textarea>
                                    </div>
                                </div>

                                <div class="inputBoxSpecial">
                                    <div class="adminAddProduct">
                                        <label for="price">Preço:</label>
                                        <input type="number" step="0.01" id="price" name="price" min="0.01" required>
                                    </div>
                                    <div class="adminAddProduct">
                                        <label for="discount">Desconto:</label>
                                        <input type="number" step="0.01" id="discount" min="0.01" max="1" name="discount">
                                    </div>
                                    <div class="adminAddProduct">
                                        <label for="stock">Stock:</label>
                                        <input type="number" id="stock" name="stock" min="0" required>
                                    </div>
                                </div>



                                <div class="productEditImg">
                                    <div class="filesBox">
                                        <div class="fileImgEdit" id="photoUploader">
                                            <label for="file">
                                                Adicionar Fotografia de Produto
                                                <br />
                                                <i class="fa fa-2x fa-camera"></i>
                                                <input type="file" name="file" id="file" class="inputfile">
                                                <br />
                                                <span class="fileName" id="fileImgName"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="addProductButton">
                                    <input type="submit" value="Adicionar Produto">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
