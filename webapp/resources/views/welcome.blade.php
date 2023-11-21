@section('content')
<div class='home'>
    <img src="{{ asset('sources/main/teste-main-3.png') }}" alt="Termos de Uso" class="background">
    <div class='buttonOnHome'>
        <a href="{{ url('/products') }}"> Sobre Nós</a>
    </div>
</div>
<div class='mainDestaques'>
    <div class="backgroundMain">
    <img src="{{ asset('sources/main/teste-main-5.png') }}" alt="Destaques" class="backgroundDestaques">
    </div>
    <div class='top4SellingProducts'>
        <div class='top4SellingProductsTitle'>
            <h2>Produtos Mais Vendidos</h2>
        </div>
        <div class='top4SellingProductsList'>
            <a href="{{ url('/products/1') }}">
                <div class='top4SellingProductsItem'>
                    <div class='top4SellingProductsItemImg'>
                        <img src="{{ asset('sources/main/sacana_extra_picante_75ml.png') }}" alt="Produto 1">
                    </div>
                    <div class='top4SellingProductsItemInfo'>
                        <h3>Produto 1</h3>
                        <p>Avaliação: 5</p>
                        <p>Preço: 10€</p>
                    </div>
                </div>
            </a>
            <a href="{{ url('/products/2') }}">
                <div class='top4SellingProductsItem'>
                    <div class='top4SellingProductsItemImg'>
                        <img src="{{ asset('sources/main/sacana_extra_picante_75ml.png') }}" alt="Produto 2">
                    </div>
                    <div class='top4SellingProductsItemInfo'>
                        <h3>Produto 2</h3>
                        <p>Avaliação: 4.9</p>
                        <p>Preço: 10€</p>
                    </div>
                </div>
            </a>
            <a href="{{ url('/products/3') }}">
                <div class='top4SellingProductsItem'>
                    <div class='top4SellingProductsItemImg'>
                        <img src="{{ asset('sources/main/sacana_extra_picante_75ml.png') }}" alt="Produto 3">
                    </div>
                    <div class='top4SellingProductsItemInfo'>
                        <h3>Produto 3</h3>
                        <p>Avaliação: 4.8</p>
                        <p>Preço: 10€</p>
                    </div>
                </div>
            </a>
            <a href="{{ url('/products/4') }}">
                <div class='top4SellingProductsItem'>
                    <div class='top4SellingProductsItemImg'>
                        <img src="{{ asset('sources/main/sacana_extra_picante_75ml.png') }}" alt="Produto 4">
                    </div>
                    <div class='top4SellingProductsItemInfo'>
                        <h3>Produto 4</h3>
                        <p>Avaliação: 4.5</p>
                        <p>Preço: 10€</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection








@if (Auth::check())
    @include('layouts.userLoggedHeaderFooter')
    
@elseif (!Auth::check())
    @include('layouts.userNotLoggedHeaderFooter')

@endif