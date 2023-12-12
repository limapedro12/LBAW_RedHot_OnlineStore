@section('content')
<section>
    <div class="editPassword">
        <div class="editPasswordTitle">
            <h1>Alterar password</h1>
        </div>

        <div class="editPasswordForm">
            <form method="post" action="/users/{{ $user->id }}/edit_password" class="editPassForm">
                @csrf

                <div class="inputBox">
                    <div class="editPassword">
                        <label for="old_password">Password antiga:</label>
                        <input type="password" id="old_password" name="old_password" placeholder="Password antiga" required>
                    </div>
                </div>

                <div class="inputBox">
                    <div class="editPassword">
                        <label for="new_password">Nova password:</label>
                        <input type="password" id="new_password" name="new_password" placeholder="Nova password" required>
                    </div>
                </div>

                <div class="inputBox">
                    <div class="editPassword">
                        <label for="new_password_confirmation">Confirme a nova password:</label>
                        <input type="password" id="new_password_confirmation" name="new_password_confirmation" placeholder="Confirme a nova password" required>
                    </div>
                </div>

                <div class="editPasswordButton">
                    <input type="submit" value="Alterar">
                </div>
            </form>
        </div>

        <div class="finalLinksPass">
            <div class="deleteAccountPass">
                <a href="/users/{{ $user->id }}/delete_account"><i class="fas fa-trash-alt"></i> Apagar Conta</a>
            </div>
            <div class="editProfilePass">
                <a href="/users/{{ $user->id }}/edit">Editar Perfil</a>
            </div>
            <div class="backPass">
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
