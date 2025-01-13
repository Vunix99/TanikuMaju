<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Http;

class ReviewController extends Controller
{
    public function all(): JsonResponse
    {
        $reviews = DB::table('reviews')
            ->where('public', true)
            ->select('id', 'reviewer_name', 'job', 'content', 'rating', DB::raw('NOT public as hide'))
            ->get();
    
        return response()->json($reviews);
    }
    public function index(): JsonResponse
    {
        return response()->json(Review::all());
    }

    public function show(Review $review): JsonResponse
    {
        return response()->json([
            'id' => $review->id,
            'content' => $review->content,
            'reviewer_name' => $review->reviewer_name,
            'job' => $review->job,
            'rating' => $review->rating,
            'hide' => !$review->public, // Sets 'hide' to the opposite of 'public'
        ]);
    }

    public function conceal(Review $review): JsonResponse
    {
        if (!$review->public) {
            return response()->json([
                'message' => "{$review->reviewer_name}'s review is already hidden",
            ], 400);
        }
    
        $review->public = false;
        $review->save();
    
        return response()->json([
            'message' => "{$review->reviewer_name}'s review has been hidden successfully",
            'hide' => !$review->public,
        ]);
    }
    
    public function reveal(Review $review): JsonResponse
    {
        if ($review->public) {
            return response()->json([
                'message' => "{$review->reviewer_name}'s review is already public",
            ], 400);
        }
    
        $review->public = true;
        $review->save();
    
        return response()->json([
            'message' => "{$review->reviewer_name}'s review has been set to public successfully",
            'hide' => !$review->public,
        ]);
    }
    

    public function store(Request $request): JsonResponse
    {
        // Validate incoming data
        $validated = $request->validate([
            'content' => ['required'],
            'reviewer_name' => ['required'],
            'job' => ['required'], 
            'rating' => ['required', 'integer'], 
            'hcaptcha_token' => ['required'],
        ]);
    
        // Verify hCaptcha
        $response = Http::asForm()->post('https://hcaptcha.com/siteverify', [
            'secret' => config('services.hcaptcha.secret'),
            'response' => $validated['hcaptcha_token'],
        ]);
    
        $hcaptchaData = $response->json();
        if (!$hcaptchaData['success']) {
            Log::error('hCaptcha verification failed', ['response' => $hcaptchaData]);
            return response()->json([
                'success' => false,
                'message' => 'hCaptcha verification failed',
            ], 422);
        }
    
        // Attempt to save the review
        try {
            $review = new Review();
            $review->content = $validated['content'];
            $review->reviewer_name = $validated['reviewer_name'];
            $review->job = $validated['job'];
            $review->rating = $validated['rating'];
            $review->public = $request->input('public', false); // Assign public status
    
            if (!$review->save()) {
                Log::error('Failed to save review', ['review_data' => $review]);
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to save review due to server error',
                ], 500);
            }
    
            return response()->json([
                'success' => true,
                'message' => "Review by {$validated['reviewer_name']} has been saved successfully"
            ]);
    
        } catch (\Exception $e) {
            Log::error('Error saving review', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to save review due to server error',
            ], 500);
        }
    }
    
    

    public function destroy(Review $review): JsonResponse
    {
        if (!$review->delete()) {
            return response()->json([
                'message' => "Failed to delete review by {$review->reviewer_name}"
            ], 500);
        }

        return response()->json([
            'message' => "Review by {$review->reviewer_name} has been deleted"
        ]);
    }
}
