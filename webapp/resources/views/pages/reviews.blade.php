<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviews</title>
</head>

<body>
    <h1>Reviews for product {{$id}} </h1>
    
    <div id="reviews">
        @foreach($reviews as $review)
            <p> ReviewID: {{$review->id}} / User: {{$review->id_utilizador}} -> Rating: {{$review->avaliacao}} / Comment: {{$review->texto}} / {{$review->timestamp}}</p> 

            @if(Auth::check())
                @if($review->id_utilizador == Auth::user()->id)               
                    <form method="POST" action="{{ route('editReview', ['id' => $review->id]) }}">
                        @csrf
                        <input type="submit" value="Edit Review">
                    </form>
                @else
                    <form action="{{ route('reviewDetails', ['id' => $review->id]) }}">
                        @csrf
                        <input type="submit" value="View Review">
                    </form>
                @endif
            @endif

        @endforeach
    </div>

    <br>

    <!-- Form to add a new review to a product -->
    @if(Auth::check())
        <form method="POST" action="{{ route('addReview', ['id' => $id]) }}" id="reviewForm">
            @csrf 

            <label for="rating">Rating:</label><br>
                <input type="radio" id="1" name="rating" value="1"> <label for="">1</label><br>
                <input type="radio" id="2" name="rating" value="2"> <label for="">2</label><br>
                <input type="radio" id="3" name="rating" value="3" checked> <label for="">3</label><br>
                <input type="radio" id="4" name="rating" value="4"> <label for="">4</label><br>
                <input type="radio" id="5" name="rating" value="5"> <label for="">5</label><br>

            <label for="comment">Comment:</label><br>
            <input type="text" id="comment" name="comment" required><br>
        
            <input type="hidden" id="timestamp" name="timestamp">

            <input type="submit" value="Add Review">
        </form>
    @endif

    <script>
        // Set the current timestamp in the 'Y-m-d H:i:s' format when the form is submitted
        document.getElementById('reviewForm').addEventListener('submit', function () {
            const currentTimestamp = new Date().toISOString().slice(0, 19).replace("T", " ");
            document.getElementById('timestamp').value = currentTimestamp;
        });
    </script>

</body>
