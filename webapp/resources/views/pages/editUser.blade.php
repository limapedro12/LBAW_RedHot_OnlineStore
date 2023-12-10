@section('content')
    <section>
        <div class="profileEdit">
            <div class="profileEditTitle">
                <h1>Editar Perfil</h1>
            </div>
            <div class="profileEditForm">
                <form method="post" action="/users/{{ $user->id }}/edit" enctype="multipart/form-data"
                    class="userEditForm">
                    @csrf


                    <div class="changes">
                        @if ($user->hasPhoto())
                            <div class="profileEditImg">
                                <div class="profileImgOnEdit">
                                    <img src="{{ $user->getProfileImage() }}" alt="Foto de Perfil">
                                </div>
                                <div class="filesBox">
                                    <div class="fileImgEdit">
                                        <label for="file">
                                            <i class="fa fa-2x fa-camera"></i> 
                                            Editar Fotografia de Perfil
                                            <input type="file" name="file" id="file" class="inputfile">
                                            <br />
                                            <span class="fileName" id="fileImgName"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="filesBox">
                                    <div class="fileImgDelete">
                                        <input type="checkbox" id="deletePhoto" name="deletePhoto">
                                        <label for="deletePhoto">
                                            <i class="fa fa-2x fa-trash"></i>
                                            Apagar Fotografia de Perfil
                                        </label>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="profileEditImg">
                                <div class="profileImgOnEdit">
                                    <img src="{{ asset('/profile/default.png') }}" alt="Foto de Perfil">
                                </div>
                                <div class="filesBox">
                                    <div class="fileImgEdit">
                                        <label for="file">
                                            Adicionar Fotografia de Perfil
                                            <br />
                                            <i class="fa fa-2x fa-camera"></i>
                                            <input type="file" name="file" id="file" class="inputfile">
                                            <br />
                                            <span class="fileName" id="fileImgName"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        @endif


                        <div class="profileEditInfo">

                            <div class="profileEditInfoTitle">
                                <h1>Detalhes</h1>
                            </div>

                            <div class="info">
                                <div class="inputBox">
                                    <label for="nome">Nome</label>
                                    <input type="text" id="nome" name="nome" value="{{ $user->nome }}"
                                        placeholder="Nome">
                                    @if ($errors->has('nome'))
                                        <p class="textDanger">
                                            {{ $errors->first('nome') }}
                                        </p>
                                    @endif
                                </div>

                                <div class="inputBox">
                                    <label for="email">Email</label>
                                    <input type="text" id="email" name="email" value="{{ $user->email }}"
                                        placeholder="Email">
                                    @if ($errors->has('email'))
                                        <p class="textDanger">
                                            {{ $errors->first('email') }}
                                        </p>
                                    @endif
                                </div>

                                <div class="inputBox">
                                    <label for="telefone">Telefone</label>
                                    <input type="text" id="telefone" name="telefone" value="{{ $user->telefone }}"
                                        placeholder="Telefone">
                                    @if ($errors->has('telefone'))
                                        <p class="textDanger">
                                            {{ $errors->first('telefone') }}
                                        </p>
                                    @endif
                                </div>

                                <div class="inputBox">
                                    <label for="morada">Morada</label>
                                    <input type="text" id="morada" name="morada" value="{{ $user->morada }}"
                                        placeholder="Morada">
                                    @if ($errors->has('morada'))
                                        <p class="textDanger">
                                            {{ $errors->first('morada') }}
                                        </p>
                                    @endif
                                </div>

                                <div class="inputBox">
                                    <label for="codigo_postal">Código Postal</label>
                                    <input type="text" id="codigo_postal" name="codigo_postal"
                                        value="{{ $user->codigo_postal }}" placeholder="Código Postal">
                                    @if ($errors->has('codigo_postal'))
                                        <p class="textDanger">
                                            {{ $errors->first('codigo_postal') }}
                                        </p>
                                    @endif
                                </div>

                                <div class="inputBox">
                                    <label for="localidade">Localidade</label>
                                    <input type="text" id="localidade" name="localidade" value="{{ $user->localidade }}"
                                        placeholder="Localidade">
                                    @if ($errors->has('localidade'))
                                        <p class="textDanger">
                                            {{ $errors->first('localidade') }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="confirm">
                        <div class="confirmPassword">

                            <div class="inputBox">
                                <label for="password">Password</label>
                                <input type="password" id="password" name="password" required placeholder="Password"
                                    required>
                                @if ($errors->has('password'))
                                    <p class="textDanger">
                                        {{ $errors->first('password') }}
                                    </p>
                                @endif
                            </div>

                            <div class="inputBox">
                                <label for="password-confirm">Confirmar Password</label>
                                <input id="password-confirm" type="password" name="password_confirmation"
                                    placeholder="Confirmar Password" required>
                                @if ($errors->has('password_confirmation'))
                                    <p class="textDanger">
                                        {{ $errors->first('password_confirmation') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="confirmButton">
                            <input type="submit" value="Submeter" class="btn" name="Save">
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="finalLinks">
            <div class="deleteAccount">
                <a href="/users/{{ $user->id }}/delete_account"><i class="fas fa-trash-alt"></i> Apagar Conta</a>
            </div>
            <div class="passwordChange">
                <a href="/users/{{ $user->id }}/edit_password">Alterar Password</a>
            </div>
            <div class="back">
                <a href="/users/{{ $user->id }}">Voltar para Perfil <i class="fas fa-arrow-right"></i></a>
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
