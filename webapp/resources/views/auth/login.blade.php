<head>
    <title>Login | RedHot</title>
</head>

@extends('layouts.userNotLoggedHeaderFooter')

@section('content')
    <section class ="login">
        <div class="loginLogo">
            <img src="{{ asset('sources/logo/logo_lbaw-black.png') }}" alt="logo">
        </div>

        <div class="loginInput">
            <h2 class ="title">Login</h2>
            <form method="POST" action="{{ route('login') }}" class="loginContainer">
                {{ csrf_field() }}

                <div class="inputBox">
                    <input id="email" type="email" name="email" placeholder="Email" value="{{ old('email') }}"
                        required autofocus>
                    @if ($errors->has('email'))
                        <p class="text-danger">
                            {{ $errors->first('email') }}
                        </p>
                    @endif
                </div>

                <div class="inputBox">
                    <input id="password" type="password" name="password" placeholder="Password" required>
                    @if ($errors->has('password'))
                        <p class="text-danger">
                            {{ $errors->first('password') }}
                        </p>
                    @endif
                </div>

                <div class="loginOptions">
                    <button type="submit">
                        <span class="loginBtn">
                            <i class="fas fa-arrow-right"></i>
                        </span>
                    </button>

                    <div class="stayLoggedIn">
                        <input type="checkbox" id="stayLoggedInCheck" value="true" {{ old('remember') ? 'checked' : '' }}>
                        <label for="stayLoggedInCheck">Lembrar-me</label>
                    </div>
                </div>

                <div class="loginLinks">
                    <a href="{{ route('forgetPassword') }}">Esqueceu-se da password?</a>
                    <a href="{{ route('register') }}">Ainda não tem conta?</a>
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
