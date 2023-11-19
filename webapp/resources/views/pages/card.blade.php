@extends('layouts.app')

@section('title', $card->name)

@section('content')
    <section id="cards">
        @include('partials.card', ['card' => $card])
    </section>
    <p> {{ $dunas }} </p>
@endsection