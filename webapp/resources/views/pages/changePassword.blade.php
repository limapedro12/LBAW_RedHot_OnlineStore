@section('content')

    <h1>Formulário para resetar a password de {{$user->nome}}</h1>
    <form method="post" action="/users/{{$user->id}}/change_password/{{$token}}">
        @csrf
        <label for="password">Nova password</label>
        <div class="inputBox">
            <input type="password" id="password" name="password" required><br><br>
        </div>
        <label for="password">Confirmar nova password</label>
        <div>
            <input type="password" id="password-confirm" name="password_confirmation" required><br><br>
        </div>
            <input type="submit" value="Submeter">
    </form>
        
@endsection

@if (Auth::guard('admin')->check())
    @include('layouts.adminHeaderFooter')
@elseif (Auth::check())
    @include('layouts.userLoggedHeaderFooter')
@else
    @include('layouts.userNotLoggedHeaderFooter')
@endif
