@section('content')
    <section>
        <h1>Comentários do produto {{ $product->nome }} </h1>

        <section id="reviews">
            @foreach ($reviews as $review)
                <article class="review" reviewId="{{ $review->id }}">
                    <h3>Utilizador: {{ $review->id_utilizador }}</h3>
                    <h3>Avaliação: {{ $review->avaliacao }}</h3>
                    <h4>Comentário: {{ $review->texto }}</h4>
                    <p>{{ $review->timestamp }}</p>
                </article>

                @if (Auth::check())
                    @if ($review->id_utilizador == Auth::user()->id)
                        <form method="GET"
                            action="{{ route('editReviewForm', ['id_review' => $review->id, 'id_product' => $id_product]) }}"
                            class="editReviewForm" reviewId="{{ $review->id }}">
                            @csrf
                            <input type="submit" value="Edit Review">
                        </form>

                        <form method="POST"
                            action="{{ route('deleteReview', ['id_review' => $review->id, 'id_product' => $id_product]) }}"
                            class="deleteReviewForm" reviewId="{{ $review->id }}" productId="{{ $id_product }}">
                            @csrf
                            <input type="submit" value="Delete Review">
                        </form>
                    @endif
                @endif

                @if (Auth::guard('admin')->check())
                    <form method="POST"
                        action="{{ route('adminDeleteReview', ['id_review' => $review->id, 'id_product' => $id_product]) }}"
                        class="adminDeleteReview" reviewId="{{ $review->id }}" productId="{{ $id_product }}">
                        @csrf
                        <input type="submit" value="Delete Review">
                    </form>
                @endif

            @endforeach
        </section>

        <h2 class="alertMessage"></h2>

        <br>

        <!-- Form to add a new review to a product -->
        @if (Auth::check())
            <form method="POST" action="{{ route('addReview', ['id_product' => $id_product]) }}" class="addReviewForm"
                reviewId="{{ $id_product }}">
                @csrf

                <label for="rating">Avaliação:</label><br>
                <input type="radio" id="1" name="rating" value="1"> <label for="">1</label><br>
                <input type="radio" id="2" name="rating" value="2"> <label for="">2</label><br>
                <input type="radio" id="3" name="rating" value="3" checked> <label
                    for="">3</label><br>
                <input type="radio" id="4" name="rating" value="4"> <label for="">4</label><br>
                <input type="radio" id="5" name="rating" value="5"> <label for="">5</label><br>

                <label for="comment">Comentário:</label><br>
                <input type="text" id="comment" name="comment" required><br>

                <input type="hidden" id="timestamp" name="timestamp">

                <input type="submit" value="Add Review">
            </form>
        @endif

        <script>
            // Set the current timestamp in the 'Y-m-d H:i:s' format when the form is submitted
            document.querySelector('form.addReviewForm').addEventListener('submit', function() {
                const currentTimestamp = new Date().toISOString().slice(0, 19).replace("T", " ");
                document.getElementById('timestamp').value = currentTimestamp;
            });
        </script>

    </section>
@endsection

@if (Auth::guard('admin')->check())
    @include('layouts.adminHeaderFooter')
@elseif (Auth::check())
    @include('layouts.userLoggedHeaderFooter')
@else
    @include('layouts.userNotLoggedHeaderFooter')
@endif
