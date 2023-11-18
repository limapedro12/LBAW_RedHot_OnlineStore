<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review</title>
</head>

<body>
    <p> {{$review->id_utilizador}} -> Rating: {{$review->avaliacao}} / Comment: {{$review->texto}} / {{$review->timestamp}}</p>

    @if (Auth::check() && $review->id_utilizador == Auth::user()->id)

        <form method="POST" action="{{ route('editReview', ['id' => $review->id]) }}">
            @csrf

            <label for="rating">Rating:</label><br>
            <input type="radio" id="1" name="rating" value="1" {{ $review->avaliacao == 1 ? 'checked' : '' }}> <label for="1">1</label><br>
            <input type="radio" id="2" name="rating" value="2" {{ $review->avaliacao == 2 ? 'checked' : '' }}> <label for="2">2</label><br>
            <input type="radio" id="3" name="rating" value="3" {{ $review->avaliacao == 3 ? 'checked' : '' }}> <label for="3">3</label><br>
            <input type="radio" id="4" name="rating" value="4" {{ $review->avaliacao == 4 ? 'checked' : '' }}> <label for="4">4</label><br>
            <input type="radio" id="5" name="rating" value="5" {{ $review->avaliacao == 5 ? 'checked' : '' }}> <label for="5">5</label><br>

            <label for="comment">Comment:</label><br>
            <input type="text" id="comment" name="comment" value="{{ $review->texto }}" required><br>

            <input type="hidden" id="timestamp" name="timestamp" value="{{ $review->timestamp }}">

            <input type="submit" value="Edit Review">
        </form>

        <form method="POST" action="{{ route('deleteReview', ['id' => $review->id]) }}">
            @csrf
            <input type="submit" value="Delete Review">
        </form>

    @endif
</body>
</html>
