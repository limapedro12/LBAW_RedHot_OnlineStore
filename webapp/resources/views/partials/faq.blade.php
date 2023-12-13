@extends('layouts.adminHeaderFooter')

@section('content')
    <section>
        <h3>Pergunta: {{ $faq->pergunta }}</h3>
        <h3>Resposta: {{ $faq->resposta }}</h3>

        <form method="POST" action="{{ route('editFaqs', ['id' => $faq->id]) }}">
            @csrf

            <label for="name">Pergunta:</label>
            <input type="text" id="pergunta" name="pergunta" value="{{ $faq->pergunta }}" required><br><br>

            <label for="name">Resposta:</label>
            <input type="text" id="resposta" name="resposta" value="{{ $faq->resposta }}" required><br><br>

            <button type="submit" class="adminFAQButton">Editar FAQ</button>
        </form>

    </section>
@endsection
