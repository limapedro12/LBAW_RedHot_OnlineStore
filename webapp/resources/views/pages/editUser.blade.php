@section('content')
<section>
        <h1>A editar perfil de {{$user->nome}}</h1>
        <form method="post" action="/users/{{$user->id}}/edit" enctype="multipart/form-data">
            @csrf
            <label for="nome">Nome</label>
            <input type="text" id="nome" name="nome" value="{{$user->nome}}"><br><br>
            <div id="photoUploader">
                <label for="file">Fotografia de Perfil</label><br>
                <input name="file" type="file" id="file"><br><br>
            </div>
            <label for="deletePicture">Apagar Fotografia de Perfil</label>
            <input type="checkbox" id="deletePhoto" name="deletePhoto"><br><br>
            <label for="email">E-mail</label>
            <input type="text" id="email" name="email" value="{{$user->email}}"><br><br>
            <label for="email">Password</label>
            <input type="password" id="password" name="password" required><br><br> 
            <input type="submit" value="Submeter">
        </form>
    </section>
@endsection

@if (Auth::guard('admin')->check())
    @include('layouts.adminHeaderFooter')
@elseif (Auth::check())
    @include('layouts.userLoggedHeaderFooter')
@else
    @include('layouts.userNotLoggedHeaderFooter')
@endif

