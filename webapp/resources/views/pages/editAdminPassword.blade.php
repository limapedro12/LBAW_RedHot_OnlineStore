@section('content')
    <section>
        <div class="editPassword">
            <div class="editPasswordTitle">
                <h1>Alterar password</h1>
            </div>

            <div class="editPasswordForm">
                <form method="post" action="/adminProfile/edit_password" class="editPassForm">
                    @csrf

                    <div class="inputBox">
                        <div class="editPassword">
                            <label for="old_password">Password antiga:</label>
                            <input type="password" id="old_password" name="old_password" placeholder="Password antiga"
                                required>
                        </div>
                    </div>

                    <div class="inputBox">
                        <div class="editPassword">
                            <label for="new_password">Nova password:</label>
                            <input type="password" id="new_password" name="new_password" placeholder="Nova password"
                                required>
                        </div>
                    </div>

                    <div class="inputBox">
                        <div class="editPassword">
                            <label for="new_password_confirmation">Confirme a nova password:</label>
                            <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                                placeholder="Confirme a nova password" required>
                        </div>
                    </div>

                    <div class="editPasswordButton">
                        <input type="submit" value="Alterar">
                    </div>
                </form>
            </div>

            <div class="finalLinksPass">
                <div class="editProfilePass">
                    <a href="/adminProfile/edit">Editar Perfil</a>
                </div>
                <div class="backPass">
                    <a href="/adminProfile">Perfil <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </section>
@endsection

@include('layouts.adminHeaderFooter')
