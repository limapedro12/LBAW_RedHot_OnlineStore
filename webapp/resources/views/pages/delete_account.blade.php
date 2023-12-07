@section('content')\
<section>
        <h1>A eliminar conta de {{$user->nome}}</h1>
        <form method="post" action="/users/{{$user->id}}/delete_account">
            @csrf
            <label for="email">Para proceder, digite a sua palavra-passe:</label>
            <input type="password" id="password" name="password" required><br><br> 
            <input type="submit" value="Confirmar eliminação">
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

