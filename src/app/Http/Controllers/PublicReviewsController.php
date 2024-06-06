<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;


class PublicReviewsController extends BaseController
{
    public function getPublicReviews()
    {
        $results = DB::table('reviews')
            ->where('status', 1)
            ->where('order', 1)
            ->get();
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

        dd($formattedResults);

        echo json_encode($formattedResults);

    }
}
