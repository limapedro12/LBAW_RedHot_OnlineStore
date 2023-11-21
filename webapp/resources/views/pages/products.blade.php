@section('content')
<section>
    <h1>Lista de Produtos</h1>
        @include('partials.searchAndFilterForms')
    <div id='listOfProducts'>
        @foreach ($products as $product) 
            <section class="productListItem">
                <img src="{{ $product->url_imagem }}" alt="{{ $product->nome }}" height = "100">
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
            </section>
        @endforeach
    </div>
</section>
@endsection

@if (Auth::guard('admin')->check())
    @include('layouts.adminHeaderFooter')
@elseif (Auth::check())
    @include('layouts.userLoggedHeaderFooter')
@else
    @include('layouts.userNotLoggedHeaderFooter')
@endif
