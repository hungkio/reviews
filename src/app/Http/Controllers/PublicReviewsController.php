<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;


class PublicReviewsController extends Controller
{
    public function getPublicReviews()
    {
        $results = DB::table('reviews')
            ->where('status', 1)
            ->where('order', 1)
            ->get();
        dd($results);

        $formattedResults = [];

        foreach ($results as $result) {
            $user = DB::table('customers')
                ->where('customers_id', $result->customer_id)
                ->first();
            $formattedResult = [
                'name' => $user->name,
                'star' => $result->star,
                'social' => $result->source,
                'avatar' => 'https://pbs.twimg.com/profile_images/1618575477781807105/iDuRlqTe_400x400.jpg',
                'review' => $result->review
            ];

            $formattedResults[] = $formattedResult;
        }

        return json_encode($formattedResults);

    }
}
