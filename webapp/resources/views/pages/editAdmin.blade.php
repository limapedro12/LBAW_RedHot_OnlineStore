@section('content')
    <section>
        <div class="profileEdit">
            <div class="profileEditTitle">
                <h1>Editar Perfil</h1>
            </div>
            <div class="profileEditForm">
                <form method="post" action="/adminProfile/edit" enctype="multipart/form-data"
                    class="userEditForm">
                    @csrf

                    <div class="changes">
                        @if ($admin->hasPhoto())
                            <div class="profileEditImg">
                                <div class="profileImgOnEdit">
                                    <img src="{{ $admin->getProfileImage() }}" alt="Foto de Perfil">
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
                                    <img src="{{ asset('/admin_profile/default.png') }}" alt="Foto de Perfil">
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
                                    <input type="text" id="nome" name="nome" value="{{ $admin->nome }}"
                                        placeholder="Nome">
                                    @if ($errors->has('nome'))
                                        <p class="textDanger">
                                            {{ $errors->first('nome') }}
                                        </p>
                                    @endif
                                </div>

                                <div class="inputBox">
                                    <label for="email">Email</label>
                                    <input type="text" id="email" name="email" value="{{ $admin->email }}"
                                        placeholder="Email">
                                    @if ($errors->has('email'))
                                        <p class="textDanger">
                                            {{ $errors->first('email') }}
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
            <div class="passwordChange">
                <a href="/adminProfile/edit_password">Alterar Password</a>
            </div>
            <div class="back">
                <a href="/adminProfile">Voltar para Perfil <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>

    </section>
@endsection

@include('layouts.adminHeaderFooter')
