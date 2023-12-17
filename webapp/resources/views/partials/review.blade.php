<head>
    <title>Editar Comentário | RedHot</title>
</head>

@section('content')
    <section>
        <article class="review" reviewId="{{ $review->id }}">
            <h3>Utilizador: {{ $review->id_utilizador }}</h3>
            <h3>Avaliação: {{ $review->avaliacao }}</h3>
            <h4>Comentário: {{ $review->texto }}</h4>
            <p>{{ $review->timestamp }}</p><br>
        </article>

        @if (Auth::check() && $review->id_utilizador == Auth::user()->id)
            <form method="POST" class="editEachReview"
                action="{{ route('editReview', ['id_review' => $review->id, 'id_product' => $id_product]) }}">
                @csrf

                <label for="rating">Avaliação:</label><br>
                <input type="radio" id="1" name="rating" value="1"
                    {{ $review->avaliacao == 1 ? 'checked' : '' }}> <label for="1">1</label><br>
                <input type="radio" id="2" name="rating" value="2"
                    {{ $review->avaliacao == 2 ? 'checked' : '' }}> <label for="2">2</label><br>
                <input type="radio" id="3" name="rating" value="3"
                    {{ $review->avaliacao == 3 ? 'checked' : '' }}> <label for="3">3</label><br>
                <input type="radio" id="4" name="rating" value="4"
                    {{ $review->avaliacao == 4 ? 'checked' : '' }}> <label for="4">4</label><br>
                <input type="radio" id="5" name="rating" value="5"
                    {{ $review->avaliacao == 5 ? 'checked' : '' }}> <label for="5">5</label><br>

                <label for="comment">Comentário:</label><br>
                <input type="text" id="comment" name="comment" value="{{ $review->texto }}" required><br>

                <input type="hidden" id="timestamp" name="timestamp" value="{{ $review->timestamp }}">

                <input type="submit" value="Edit Review">
            </form>
        @endif

    </section>
@endsection

@if (Auth::check())
    @include('layouts.userLoggedHeaderFooter')
@elseif (!Auth::check())
    @include('layouts.userNotLoggedHeaderFooter')
@endif
