@section('content')
<div class='home'>
    <img src="{{ asset('sources/main/teste-main.png') }}" alt="Termos de Uso" class="termosDeUso">
</div>

@endsection








@if (Auth::check())
    @include('layouts.userLoggedHeaderFooter')
    
@elseif (!Auth::check())
    @include('layouts.userNotLoggedHeaderFooter')

@endif