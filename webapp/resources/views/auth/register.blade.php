@extends('layouts.userNotLoggedHeaderFooter')

@section('content')
    <section class="signup">
        <div class="signupLogo">
            <img src="{{ asset('sources/logo/logo_lbaw-black.png') }}" alt="logo">
        </div>
        <div class="signupInput">
            <h2 class="title">Registar</h2>
            <form method="POST" action="{{ route('register') }}" class="signupForm">
                {{ csrf_field() }}

                <div class="inputBox">
                    <input id="nome" type="text" name="nome" placeholder="Nome" value="{{ old('nome') }}"
                        required autofocus>
                    @if ($errors->has('nome'))
                        <p class="textDanger">
                            {{ $errors->first('nome') }}
                        </p>
                    @endif
                </div>

                <div class="inputBox">
                    <input id="email" type="email" name="email" placeholder="Email" value="{{ old('email') }}"
                        required>
                    @if ($errors->has('email'))
                        <p class="textDanger">
                            {{ $errors->first('email') }}
                        </p>
                    @endif
                </div>

                <div class="inputBox">
                    <input id="password" type="password" name="password" placeholder="Password" required>
                    @if ($errors->has('password'))
                        <span class="textDanger">
                            {{ $errors->first('password') }}
                        </span>
                    @endif
                </div>

                <div class="inputBox">
                    <input id="password-confirm" type="password" name="password_confirmation"
                        placeholder="Confirmar Password" required>
                </div>

                <div class="signupOptions">
                    <button type="submit">
                        <span class="signupBtn">
                            <i class="fas fa-arrow-right"></i>
                        </span>
                    </button>
                    <div class="signupLinks">
                        <a class="alredySignup" href="{{ route('login') }}">Já tem conta criada?</a>
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
