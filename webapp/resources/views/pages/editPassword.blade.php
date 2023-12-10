@section('content')

    <h1>A mudar a password de {{$user->nome}}</h1>
    <form method="post" action="/users/{{$user->id}}/edit_password">
        @csrf
        
        <label for="old_password">Password antiga</label>
        <div class="inputBox">
            <input type="password" name="old_password" id="old_password" required>
            @if ($errors->has('password'))
                <p class="textDanger">
                    {{ $errors->first('password') }}
                </p>
            @endif
        </div>

        <label for="new_password">Nova password</label>
        <div class="inputBox">
            <input type="password" name="new_password" id="new_password" required>
            @if ($errors->has('password_confirmation'))
                <p class="textDanger">
                    {{ $errors->first('password_confirmation') }}
                </p>
            @endif
        </div>

        <label for="new_password_confirmation">Confirme a nova password</label>
        <div class="inputBox">
            <input type="password" name="new_password_confirmation" id="new_password_confirmation" required>
        </div>

        <input type="submit" value="Alterar">
    </form>
        
@endsection

@if (Auth::guard('admin')->check())
    @include('layouts.adminHeaderFooter')
@elseif (Auth::check())
    @include('layouts.userLoggedHeaderFooter')
@else
    @include('layouts.userNotLoggedHeaderFooter')
@endif
