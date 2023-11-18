<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviews</title>
</head>

<body>
    <h1>Reviews</h1>
    
    @foreach ($reviews as $review) 
        <p>{{$review->avaliacao}} - {{$review->texto}} </p> 
    @endforeach
</body>
</html>