@section('title', 'Editar FAQ |')

@extends('layouts.adminHeaderFooter')

@section('content')
    <div class="editFaqTitle">
        <h1>Editar FAQ</h1>
    </div>
    <section class="editFaq">
        <div class="topEditFaq">

            <div class="previousQuestion">
                <h2>{{ $faq->pergunta }}</h2>
            </div>
            <div class="previousAnswer">
                <h3>{{ $faq->resposta }}</h3>
            </div>
        </div>

        <div class="bottomEditFaq">
            <div class="editFaqForm">
                <form method="POST" action="{{ route('editFaqs', ['id' => $faq->id]) }}">
                    @csrf

                    <div class="productEditTitle">
                        <label for="name">Pergunta:</label>
                        <input type="text" id="pergunta" name="pergunta" value="{{ $faq->pergunta }}" required>
                    </div>

                    <div class="productEditDescription">
                        <label for="description">Descrição:</label>
                        <textarea id="resposta" name="resposta" required>{{ $faq->resposta }}</textarea>
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

    </section>
@endsection
