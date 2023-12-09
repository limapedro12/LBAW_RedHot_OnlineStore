@section('content')
<section>
    <h1>{{$user->nome}}</h1>
    <img src="{{ $user->getProfileImage() }}" alt="Imagem de Perfil de {{ $user->nome }}" width=140px>
    <p>{{$user->email}}</p>
    <a href="/users/{{$user->id}}/edit">Editar Perfil...</a>&nbsp;&nbsp;
    <a href="/users/{{$user->id}}/delete_account">Apagar Conta...</a>&nbsp;&nbsp;
    <a href="/users/{{$user->id}}/orders">Minhas encomendas</a>&nbsp;&nbsp;
</section>
@endsection

@if (Auth::check())
    @include('layouts.userLoggedHeaderFooter')
@elseif (!Auth::check())
    @include('layouts.userNotLoggedHeaderFooter')
@endif
