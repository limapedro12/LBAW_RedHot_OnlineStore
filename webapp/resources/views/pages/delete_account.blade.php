@section('content')
    <section>
        <div class="deleteAccount">
            <div class="deleteAccountTitle">
                <h1>Eliminar conta</h1>
            </div>

            <div class="deleteAccountForm">
                <form method="post" action="/users/{{ $user->id }}/delete_account" class="delAccForm">
                    @csrf

                    <div class="inputBox">
                        <div class="deleteAccount">
                            <label for="password">Para proceder, digite a sua palavra-passe:</label>
                            <input type="password" id="password" name="password" placeholder="Password" required>
                            @if ($errors->has('password'))
                                <p class="error">
                                    {{ $errors->first('password') }}
                                </p>
                            @endif
                        </div>
                    </div>

                    <div class="deleteAccountButton">
                        <input type="submit" value="Confirmar eliminação">
                    </div>
                </form>
            </div>

            <div class="finalLinksDel">
                <div class="editProfileDel">
                    <a href="/users/{{ $user->id }}/edit"><i class="fas fa-arrow-left"></i> Editar Perfil</a>
                </div>
                <div class="passwordChangeDel">
                    <a href="/users/{{ $user->id }}/edit_password">Alterar Password</a>
                </div>
                <div class="backDel">
                    <a href="/users/{{ $user->id }}">Perfil <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
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
