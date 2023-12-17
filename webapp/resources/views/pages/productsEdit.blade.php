<head>
    <title>Editar informações de {{ $product->nome }} | RedHot</title>
</head>

@section('content')
    <section>
        <div class="productEditMainTitle">
            <h1>Editar Produto</h1>
        </div>

        <form action="/products/{{ $product->id }}/edit" method="POST" enctype="multipart/form-data">
            @csrf


            <div class="productDisplay">

                <div class="productLeft">
                    <div class="productImage">
                        <img src="{{ $product->getProductImage() }}" alt="Imagem do produto">
                    </div>
                    <div class="productBottomLeft">
                        @if ($product->hasPhoto())
                            <div class="productEditImg">
                                <div class="filesBox">
                                    <div class="fileImgEdit" id="photoUploader">
                                        <label for="file">
                                            <i class="fa fa-2x fa-camera"></i>
                                            Editar Fotografia de Produto
                                            <input type="file" name="file" id="file" class="inputfile">
                                            <br />
                                            <span class="fileName" id="fileImgName"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="filesBox">
                                    <div class="fileImgDelete">
                                        <input type="checkbox" id="deletePhoto" name="deletePhoto">
                                        <label for="deletePhoto">
                                            <i class="fa fa-2x fa-trash"></i>
                                            Apagar Fotografia de Produto
                                        </label>
                                    </div>
                                </div>
                            </div>
                        @else
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
                        @endif

                    </div>
                </div>

                <div class="productRight">
                    <div class="productInfo">
                        <div class="productEditDetails">
                            <div class="productEditTitle">
                                <label for="name">Nome:</label>
                                <input type="text" id="name" name="name" value="{{ $product->nome }}" required>
                            </div>
                            <div class="productEditCategory">
                                <label for="category">Categoria:</label>
                                <input type="text" id="category" name="category" value="{{ $product->categoria }}"
                                    required>
                            </div>

                            <div class="productEditDescription">
                                <label for="description">Descrição:</label>
                                <textarea id="description" name="description" required>{{ $product->descricao }}</textarea>
                            </div>

                            <div class="productEditPrice">
                                <label for="price">Preco:</label>
                                <input type="number" id="price" step="0.01" name="price"
                                    value="{{ $product->precoatual }}" required>
                            </div>

                            <div class="productEditDiscount">
                                <label for="discount">Desconto:</label>
                                <input type="number" step="0.01" id="discount" name="discount"
                                    value="{{ $product->desconto }}">
                            </div>

                            <div class="productEditStock">
                                <label for="stock">Stock:</label>
                                <input type="number" id="stock" name="stock" value="{{ $product->stock }}" required>
                            </div>
                        </div>
                    </div>



                    <div class="productBottomRight">

                        <div class="productEditButtons">
                            <div class="productEditSave">
                                <input type="submit" value="Guardar">
                            </div>
                            <div class="productEditCancel">
                                <a href="/products/{{ $product->id }}">Cancelar</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </section>
@endsection

@include('layouts.adminHeaderFooter')
