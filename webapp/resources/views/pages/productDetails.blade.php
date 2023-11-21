@section('content')
<section>
    <img style="height: 200px;" src="{{ $product->url_imagem }}" alt="Imagem do produto">
    <section class="productDetails">
        <h2> {{ $product->nome }} </h2> 
        <p> 
            @if($product->desconto > 0)
                <span style = "text-decoration: line-through;">
                    {{ $product->precoatual }}
                </span>&nbsp
            @endif
            {{ round($discountFunction($product->precoatual, $product->desconto), 2) }} 
        </p>
        @if($product->desconto > 0)
            <p> Desconto: {{ $product->desconto * 100 }}% </p>
            <br>
        @endif
    </section>
        @if (Auth::check() && $product->stock > 0)
            <form action="/products/{{$product->id}}/add_to_cart" method="POST">
                @csrf
                <label for="quantidade"> Quantidade: </label>
                <input type="number" name="quantidade" id="quantidade" value="1" min="1" max="{{ $product->stock }}">
                <button type="submit"> Adicionar ao carrinho </button>
            </form>
        @endif
    <section class='comments'>
        <h4> Comentários </h4>
        <form method="GET" action="{{ route('reviews', ['id_product' => $product->id]) }}" productId="{{$product->id}}" productName="{{$product->nome}}">

            <input type="submit" value="Ver comentarios">
        </form>
    </section>
@endsection        

@if (Auth::check())
    @include('layouts.userLoggedHeaderFooter')
@elseif (!Auth::check())
    @include('layouts.userNotLoggedHeaderFooter')
@endif
