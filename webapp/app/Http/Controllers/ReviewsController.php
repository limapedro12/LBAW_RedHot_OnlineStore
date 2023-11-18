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
     * Shows all reviews.
     */
    public function listReviews()
    {

        // Get all reviews.
        $reviews = Review::all();

        // Use the pages.reviews template to display all reviews.
        return view('pages.reviews', [
            'reviews' => $reviews
        ]);
    }
}
