@section('content')
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
                    {{ $discountFunction($product->precoatual, $product->desconto) }} 
                </p>
                @if($product->desconto > 0)
                <p> Desconto: {{ $product->desconto * 100 }}% </p>
                @endif
                <br>
            </section>
        @endforeach
    </div>
@endsection

@if (Auth::check())
    @include('layouts.userLoggedHeaderFooter')
    
@elseif (!Auth::check())
    @include('layouts.userNotLoggedHeaderFooter')
@endif