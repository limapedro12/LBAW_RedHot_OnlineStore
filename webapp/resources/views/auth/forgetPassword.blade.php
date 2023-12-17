@extends('layouts.userNotLoggedHeaderFooter')

@section('title', 'Recuperação de Password |')

@section('content')
    <section class="signup">
        <div class="signupLogo">
            <img src="{{ asset('sources/logo/logo_lbaw-black.png') }}" alt="logo">
        </div>
        <div class="signupInput">
            <div class="fillerFP"></div>
            <h2 class="title">Recuperar Password</h2>


            <form method="POST" action="/send" class="signupForm">
                @csrf

                <p>Introduza o email associado à sua conta de utilizador e nele receberá um link para trocar a sua password
                </p>
                <div class="inputBox">
                    <input id="email" type="email" name="email" placeholder="Email" required>
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

            </form>

            <p class="text-danger">{{ session('message') }}</p>

            @if (session('details'))
                <ul>
                    @foreach (session('details') as $detail)
                        <li>{{ $detail }}</li>
                    @endforeach
                </ul>
            @endif

        </div>
    </section>
@endsection
