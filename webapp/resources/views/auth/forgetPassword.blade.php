@extends('layouts.userNotLoggedHeaderFooter')

@section('content')
    <section class="signup">
        <div class="signupLogo">
            <img src="{{ asset('sources/logo/logo_lbaw-black.png') }}" alt="logo">
        </div>
        <div class="signupInput">
            <h2 class="title">Recuperar Password</h2>

            <form method="POST" action="/send">
                @csrf
                <label for="email">Email</label>
                <input id="email" type="email" name="email" placeholder="Email" required>
                <button type="submit">Enviar</button>
            </form>

            {{ session('message') }}

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
