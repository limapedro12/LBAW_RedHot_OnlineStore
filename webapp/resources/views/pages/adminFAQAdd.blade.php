<head>
    <title>Adicionar FAQ | RedHot</title>
</head>

@extends('layouts.adminHeaderFooter')

@section('content')
<div class="addFAQ">
    <div class="editFaqTitle">
        <h1>Adicionar FAQ</h1>
    </div>

    <div class="editFaqForm">
        <form method="POST" action="{{ route('createFaqs') }}">
            @csrf

            <div class="productEditTitle">
                <label for="name">Pergunta:</label>
                <input type="text" id="pergunta" name="pergunta" required>
            </div>

            <div class="productEditDescription">
                <label for="description">Descrição:</label>
                <textarea id="resposta" name="resposta" required></textarea>
            </div>

            <div class="productFaqButtons">
                <div class="productFaqSave">
                    <input type="submit" value="Guardar">
                </div>
                <div class="productFaqCancel">
                    <a href="/adminFAQ">Cancelar</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
