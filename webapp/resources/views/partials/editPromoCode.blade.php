@section('title', 'Editar FAQ |')

@extends('layouts.adminHeaderFooter')

@section('content')
    <div class="editFaqTitle">
        <h1>Editar Código Promocional</h1>
    </div>
    <section class="editFaq">
        <div class="adminEditPromoForm">
            <form action="{{ route('promo_codes.update', ['id' => $promoCode->id]) }}" method="POST" class="addPromoCodeForm">
                @csrf

                <div class="inputBox">
                    <div class="adminAddProduct">
                        <label for="codigo">Código:</label>
                        <input type="text" id="codigo" name="codigo" value="{{ $promoCode->codigo }}" required>
                    </div>
                    @if ($errors->has('codigo'))
                        <p class="text-danger">
                            {{ $errors->first('codigo') }}
                        </p>
                    @endif
                </div>


                <div class="inputBoxSpecial">
                    <div class="adminAddProduct">
                        <label for="data_inicio">Data de Inicio:</label>
                        <input type="date" id="data_inicio" name="data_inicio" value="2023-07-22" min="2022-01-01"
                            max="2025-12-31" required>
                        <input type="time" id="tempo_inicio" name="tempo_inicio" min="00:00" max="23:59" required>
                    </div>
                    <div class="adminAddProduct">
                        <label for="data_fim">Data de Fim:</label>
                        <input type="date" id="data_fim" name="data_fim" value="2023-07-22" min="2022-01-01"
                            max="2025-12-31" required>
                        <input type="time" id="tempo_fim" name="tempo_fim" min="00:00" max="23:59" required>
                    </div>
                </div>

                <div class="inputBoxSpecial">
                    <div class="adminAddProduct">
                        <label for="discount">Desconto:</label>
                        <input type="number" step="1" id="discount" min="1" max="100" name="discount"
                            value="{{$promoCode->desconto * 100}}" required>
                    </div>
                </div>

                <div class="addProductButton">
                    <input type="submit" value="Editar">
                </div>
            </form>
        </div>

    </section>
@endsection
