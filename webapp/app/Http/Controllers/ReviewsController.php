<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

use App\Models\Review;

class ReviewsController extends Controller
{
    /**
     * Show the review for a given id.
     */
    public function reviewDetails(string $id): View
    {
        // Get the review.
        $review = Review::findOrFail($id);

        // Use the pages.review template to display the review.
        return view('partials.review', [
            'review' => $review
        ]);
    }

    /**
     * Shows all reviews for a product.
     */
    public function listReviews(string $id)
    {

        // Get all reviews.
        $reviews = Review::where('id_produto', $id)->get();

        // Use the pages.reviews template to display all reviews.
        return view('pages.reviews', [
            'reviews' => $reviews,
            'product_id' => $id
        ]);
    }
}
