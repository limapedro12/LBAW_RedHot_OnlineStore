<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

use App\Models\Review;

class ReviewsController extends Controller
{
    /**
     * Shows all reviews for a product.
     */
    public function listReviews(string $id_product)
    {

        // Get all reviews.
        $reviews = Review::where('id_produto', $id_product)->get();

        // Use the pages.reviews template to display all reviews.
        return view('pages.reviews', [
            'reviews' => $reviews,
            'id_product' => $id_product
        ]);
    }

    /**
     * Creates a new review.
     */
    public function addReview(Request $request, $id_product)
    {
        // Create a blank new review.
        $review = new Review();

        // Set review details.
        $review->timestamp = $request->input('timestamp');
        $review->texto = $request->input('comment');
        $review->avaliacao = $request->input('rating');
        $review->id_utilizador = Auth::user()->id;
        $review->id_produto = $id_product;

        // Save the review and return it as JSON.
        $review->save();
        return response()->json($review);
    }

    
    /**
     * Show the review for a given id.
     */
    public function editReview(int $id_product, int $id_review)
    {
        // Get the review.
        $review = Review::findorfail($id_review);

        // Use the pages.review template to display the review.
        return view('partials.review', [
            'review' => $review,
            'id_product' => $id_product
        ]);
    }


    /**
     * Delete a review.
     */
    public function deleteReview(Request $request, int $id_product, int $id_review)
    {
        // Find the review.
        $review = Review::findorfail($id_review);

        // Delete the review and return it as JSON.
        $review->delete();
        return response()->json($review);
    }
}
