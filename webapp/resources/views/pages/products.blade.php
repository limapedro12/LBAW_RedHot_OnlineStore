@section('content')
<section>
    <h1>Lista de Produtos</h1>
        @include('partials.searchAndFilterForms')
    <div id='listOfProducts'>
        @foreach ($products as $product) 
            <section class="productListItem">
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
                <br>
            </section>
        @endforeach
    </div>
</section>
@endsection

@if (Auth::check())
    @include('layouts.userLoggedHeaderFooter')
    
@elseif (!Auth::check())
    @include('layouts.userNotLoggedHeaderFooter')
@endif