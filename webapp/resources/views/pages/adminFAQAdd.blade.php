@extends('layouts.adminHeaderFooter')

@section('content')

    <form method="POST" action="{{ route('createFaqs') }}">
        @csrf

            <label for="name">Pergunta:</label>
            <input type="text" id="pergunta" name="pergunta" required><br><br>

            <label for="name">Resposta:</label>
            <input type="text" id="resposta" name="resposta" required><br><br>

        <button type="submit" class="adminFAQButton">Adicionar FAQ</button>
    </form>

@endsection
