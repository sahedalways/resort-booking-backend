<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\Resort\StoreReviewRequest;
use App\Http\Requests\Review\StoreReviewRequest as ReviewStoreReviewRequest;
use App\Http\Requests\Review\UpdateReviewRequest;
use App\Models\Resort;
use App\Models\Review;




class ReviewController extends BaseController
{

    public function submitReviews(ReviewStoreReviewRequest $request)

    {
        $request->validated();

        try {
            $review = Review::create([
                'resort_id' => $request->resort_id,
                'user_id'   => auth()->id(),
                'star'    => $request->rating,
                'comment'   => $request->comment,
            ]);


            return $this->sendResponse([
                null
            ], 'Review saved successfully.');
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to submit review: ' . $e->getMessage(),
            ], 500);
        }
    }


    public function getReviews($resortId)
    {
        $resortExists = Resort::where('id', $resortId)->exists();

        if (!$resortExists) {
            return $this->sendError('Invalid resort ID or resort not found.', [], 404);
        }



        $reviews = Review::with('user:id,f_name,l_name')
            ->where('resort_id', $resortId)
            ->orderBy('created_at', 'desc')
            ->get();



        return $this->sendResponse([
            'reviews' => $reviews->map(function ($review) {
                return [
                    'id' => $review->id,
                    'user' => $review->user,
                    'user_id' => $review->user_id,
                    'star' => $review->star,
                    'comment' => $review->comment,
                    'created_at' => $review->created_at->format('Y-m-d H:i'),
                ];
            }),
        ], 'Reviews fetched successfully.');
    }



    public function updateReview(UpdateReviewRequest $request, $id)
    {
        $request->validated();

        $review = Review::find($id);

        if (!$review) {
            return response()->json([
                'success' => false,
                'message' => 'Review not found'
            ], 404);
        }

        $review->update([
            'star' => $request->star,
            'comment' => $request->comment,
        ]);

        return response()->json([
            'success' => true,
            'review' => $review,
            'message' => 'Review updated successfully'
        ]);
    }




    public function deleteReview($id)
    {
        $review = Review::find($id);

        if (!$review) {
            return response()->json([
                'success' => false,
                'message' => 'Review not found.'
            ], 404);
        }



        if (auth()->id() !== $review->user_id) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to delete this review.'
            ], 403);
        }

        $review->delete();

        return response()->json([
            'success' => true,
            'message' => 'Review deleted successfully.'
        ]);
    }
}
