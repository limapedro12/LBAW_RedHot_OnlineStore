@section('title', 'Editar Comentário |')

@section('content')
    <section>
        @if (Auth::check() && $review->id_utilizador == Auth::user()->id)
            <form method="POST" class="editEachReview"
                action="{{ route('editReview', ['id_review' => $review->id, 'id_product' => $id_product]) }}">
                @csrf
                <div class="editReviewForProduct">
                    <h1>{{ $review->getProductNameById($review->id_produto) }}</h1>
                </div>
                <div id="reviews">
                    <div class="reviewsTitle">
                        <i class="fa-solid fa-pepper-hot"></i>
                        <h2>Editar Avaliação</h2>
                        <i class="fa-solid fa-heart"></i>
                    </div>
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
                                    <h3>Avaliação Anterior:</h3>
                                </div>
                                <div class="reviewRatingOptions">
                                    @for ($i = 0; $i < $review->avaliacao; $i++)
                                        <i class="fas fa-heart"></i>
                                    @endfor
                                </div>
                            </div>
                        </div>
                        <div class="reviewComment">
                            <div class="reviewCommentText">
                                <textarea id="comment" name="comment" value="{{ $review->texto }}" required>{{ $review->texto }}</textarea>
                            </div>
                        </div>
                    </div>



                    <div class="editReviewRating">
                        <div class="editReviewRatingTitle">
                            <label for="rating">Avaliação:</label>
                        </div>
                        <div class="editRatingOptions">
                            <div class="editRatingOption">
                                <input type="radio" id="5" name="rating" value="5"
                                    {{ $review->avaliacao == 5 ? 'checked' : '' }}> <label for="5"><i
                                        class="fas fa-heart"></i><i class="fas fa-heart"></i><i class="fas fa-heart"></i><i
                                        class="fas fa-heart"></i><i class="fas fa-heart"></i></label>
                            </div>
                            <div class="editRatingOption">
                                <input type="radio" id="4" name="rating" value="4"
                                    {{ $review->avaliacao == 4 ? 'checked' : '' }}> <label for="4"><i
                                        class="fas fa-heart"></i><i class="fas fa-heart"></i><i class="fas fa-heart"></i><i
                                        class="fas fa-heart"></i></label>
                            </div>
                            <div class="editRatingOption">
                                <input type="radio" id="3" name="rating" value="3"
                                    {{ $review->avaliacao == 3 ? 'checked' : '' }}> <label for="3"><i
                                        class="fas fa-heart"></i><i class="fas fa-heart"></i><i
                                        class="fas fa-heart"></i></label>
                            </div>
                            <div class="editRatingOption">
                                <input type="radio" id="2" name="rating" value="2"
                                    {{ $review->avaliacao == 2 ? 'checked' : '' }}> <label for="2"><i
                                        class="fas fa-heart"></i><i class="fas fa-heart"></i></label>
                            </div>
                            <div class="editRatingOption">
                                <input type="radio" id="1" name="rating" value="1"
                                    {{ $review->avaliacao == 1 ? 'checked' : '' }}> <label for="1"><i
                                        class="fas fa-heart"></i></label>
                            </div>
                        </div>
                    </div>



                </div>
                <div class="editReviewButtons">
                    <input type="submit" value="Editar Avaliação">
                    <a href="{{ url('/products/' . $id_product . '/reviews') }}">Cancelar</a>
                </div>
            </form>
        @endif
    </section>
@endsection

@if (Auth::check())
    @include('layouts.userLoggedHeaderFooter')
@elseif (!Auth::check())
    @include('layouts.userNotLoggedHeaderFooter')
@endif
