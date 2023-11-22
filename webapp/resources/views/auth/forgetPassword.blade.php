@extends('layouts.userNotLoggedHeaderFooter')

@section('content')
    <section class="signup">
        <div class="signupLogo">
            <img src="{{ asset('sources/logo/logo_lbaw-black.png') }}" alt="logo">
        </div>
        <div class="signupInput">
            <h2 class="title">Recuperar Password</h2>
            <form method="POST" action="" class="signupForm">
                {{ csrf_field() }}

                <p>
                    Entendemos que às vezes é fácil esquecer sua a password e estamos aqui para ajudá-lo a recuperá-la. 
                    Se você estiver a ter problemas ao tentar aceder à sua conta, basta inserir o seu endereço de e-mail registado no campo fornecido. 
                    Enviaremos um e-mail com instruções sobre como redefinir a sua password com segurança.
                    Certifique-se de que o endereço de e-mail inserido seja o mesmo associado à sua conta na RedHot. 
                    Se não receber o e-mail de redefinição de password dentro de alguns minutos, verifique a sua pasta de spam ou tente novamente. 
                    Na RedHot, priorizamos a segurança das informações da sua conta. 
                    Fique com a certeza de que os seus dados pessoais serão tratados com a máxima confidencialidade durante o processo de recuperação de password.
                </p>


                <div class="inputBox">
                    <input id="email" type="email" name="email" placeholder="Email" value="{{ old('email') }}"
                        required>
                    @if ($errors->has('email'))
                        <p class="textDanger">
                            {{ $errors->first('email') }}
                        </p>
                    @endif
                </div>

                <div class="signupOptions">
                    <button type="submit">
                        <span class="forgotPasswordBtn">
                            <i class="fas fa-arrow-right"></i>
                        </span>
                    </button>
                    <div class="signupLinks">
                        <a class="goBack" href="{{ route('login') }}">Voltar para o Login! <i
                                class="fas fa-arrow-right"></i></a>
                    </div>
                </div>

                <section id="messages">
                    @if (session('success'))
                        <p class="success">
                            {{ session('success') }}
                        </p>
                    @endif
                </section>
            </form>
        </div>
    </section>
@endsection
