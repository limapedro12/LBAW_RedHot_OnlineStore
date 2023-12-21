@section('title', 'Comentários de' . $product->nome . ' |')

@section('content')
    <section>

        <div class="productDetailsBreadcrumb">
            <p>
                <a href="{{ url('/') }}">Home</a> > <a href="{{ url('/products') }}">Produtos</a> > <a
                    href="{{ url('/products/' . $product->id) }}"> {{ $product->nome }}</a> > Avaliações
            </p>
        </div>

        <div class="productReviewTitle">
            <h1>{{ $product->nome }} </h1>
            <h1> {{ $product->getProductRating() }} <i class="fas fa-heart"></i></h1>
        </div>

        <div class ="addReview">
            <!-- Form to add a new review to a product -->
            @if (Auth::check())
                <form method="POST" action="{{ route('addReview', ['id_product' => $id_product]) }}" class="addReviewForm"
                    reviewId="{{ $id_product }}">
                    @csrf
                    <div class="addReviewTitle">
                        <i class="fa-solid fa-pepper-hot"></i>
                        <h2>Adicionar Avaliação</h2>
                        <i class="fa-solid fa-heart"></i>
                    </div>
                    <div class="addReviewInputs">
                        <div class="addReviewComment">
                            <label for="comment">Comentário:</label>
                            <textarea type="text" id="comment" name="comment" required></textarea>
                        </div>
                        <div class="addReviewRating">
                            <div class="addReviewRatingTitle">
                                <label for="rating">Avaliação:</label>
                            </div>
                            <div class="addRatingOptions">
                                <div class="addRatingOption">
                                    <input type="radio" id="5" name="rating" value="5">
                                    <label for="5">
                                        <i class="fas fa-heart"></i><i class="fas fa-heart"></i><i
                                            class="fas fa-heart"></i><i class="fas fa-heart"></i><i
                                            class="fas fa-heart"></i>
                                    </label>
                                </div>
                                <div class="addRatingOption">
                                    <input type="radio" id="4" name="rating" value="4">
                                    <label for="4">
                                        <i class="fas fa-heart"></i><i class="fas fa-heart"></i><i
                                            class="fas fa-heart"></i><i class="fas fa-heart"></i>
                                    </label>
                                </div>
                                <div class="addRatingOption">
                                    <input type="radio" id="3" name="rating" value="3" checked>
                                    <label for="3">
                                        <i class="fas fa-heart"></i><i class="fas fa-heart"></i><i class="fas fa-heart"></i>
                                    </label>
                                </div>
                                <div class="addRatingOption">
                                    <input type="radio" id="2" name="rating" value="2">
                                    <label for="2">
                                        <i class="fas fa-heart"></i><i class="fas fa-heart"></i>
                                    </label>
                                </div>
                                <div class="addRatingOption">
                                    <input type="radio" id="1" name="rating" value="1">
                                    <label for="1">
                                        <i class="fas fa-heart"></i>
                                    </label>
                                </div>
                            </div>
                            <div class="addReviewSubmit">
                                <input type="submit" value="Submeter">
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="timestamp" name="timestamp">
                </form>
            @endif
        </div>


        <div id="reviews">
            <div class="reviewsTitle">
                <i class="fa-solid fa-pepper-hot"></i>
                <h2>Avaliações</h2>
                <i class="fa-solid fa-heart"></i>
            </div>
            @foreach ($reviews as $review)
                <div class="review" reviewId="{{ $review->id }}">

                    <div class="reviewBar">
                        <div class="reviewUser">
                            <div class="reviewUserImg">
                                <img src="{{ asset($review->getUserProfileImgById($review->id_utilizador)) }}"
                                    alt="User Image">
                            </div>
                            <div class="reviewUserName">
                                <h2>{{ $review->getUserNameById($review->id_utilizador) }}</h2>
                            </div>
                        </div>

                        <div class="reviewRating">
                            <div class="reviewRatingTitle">
                                <h3>Avaliação:</h3>
                            </div>
                            <div class="reviewRatingOptions">
                                @for ($i = 0; $i < $review->avaliacao; $i++)
                                    <i class="fas fa-heart"></i>
                                @endfor
                            </div>

                            <div class="reviewButtonsEditDelete">
                                @if (Auth::check())
                                    @if ($review->id_utilizador == Auth::user()->id)
                                        <form method="GET"
                                            action="{{ route('editReviewForm', ['id_review' => $review->id, 'id_product' => $id_product]) }}"
                                            class="editReviewForm" reviewId="{{ $review->id }}">
                                            @csrf
                                            <button type="submit"> <i class="fa-solid fa-file-pen"></i></button>
                                        </form>

                                        <form method="POST"
                                            action="{{ route('deleteReview', ['id_review' => $review->id, 'id_product' => $id_product]) }}"
                                            class="deleteReviewForm" reviewId="{{ $review->id }}"
                                            productId="{{ $id_product }}">
                                            @csrf
                                            <button type="submit"> <i class="fa-solid fa-trash"></i> </button>
                                        </form>
                                    @endif
                                @endif

                                @if (Auth::guard('admin')->check())
                                    <form method="POST"
                                        action="{{ route('adminDeleteReview', ['id_review' => $review->id, 'id_product' => $id_product]) }}"
                                        class="adminDeleteReview" reviewId="{{ $review->id }}"
                                        productId="{{ $id_product }}">
                                        @csrf
                                        <button type="submit"> <i class="fa-solid fa-trash"></i> </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="reviewComment">
                        <div class="reviewCommentTimestamp">
                            @if ($review->editado == true)
                                <p>Editada à: {{ $review->getHowLongTheCommentWas($review->id) }}</p>
                            @else
                                <p>{{ $review->getHowLongTheCommentWas($review->id) }}</p>
                            @endif
                        </div>
                        <div class="reviewCommentText">
                            <p>{{ $review->texto }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

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
