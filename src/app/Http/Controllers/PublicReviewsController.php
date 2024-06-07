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
                'social' => $this->getSocialLogo($result->source),
                'avatar' => 'https://pbs.twimg.com/profile_images/1618575477781807105/iDuRlqTe_400x400.jpg',
                'review' => $result->review
            ];

            $formattedResults[] = $formattedResult;
        }

        return json_encode($formattedResults);
    }

    public function  getOverviewReviews()
    {
        $reviews = DB::table('reviews')
            ->where('status', 1)
            ->where('order', 1)
            ->get();

        $stars = $reviews->pluck('star')->toArray();

        if (count($stars) > 0) {
            $roundedAverage = array_sum($stars) / count($stars);
        } else {
            $roundedAverage = 0;
        }

        $results = [
            "star" => $roundedAverage,
            "total" => count($reviews)
        ];

        return json_encode($results);
    }

    public function getSocialLogo($social)
    {
        switch ($social) {
            case 'X':
            case 'Twitter':
                return "https://assets-global.website-files.com/5d66bdc65e51a0d114d15891/64cebc6c19c2fe31de94c78e_X-vector-logo-download.png";
            case 'LinkedIn':
                return "https://cdn.iconscout.com/icon/free/png-256/free-linkedin-circle-1868976-1583140.png?f=webp";
            case 'Facebook':
                return "https://upload.wikimedia.org/wikipedia/commons/thumb/0/05/Facebook_Logo_%282019%29.png/800px-Facebook_Logo_%282019%29.png";
            case 'Google':
                return "https://upload.wikimedia.org/wikipedia/commons/thumb/c/c1/Google_%22G%22_logo.svg/1024px-Google_%22G%22_logo.svg.png";
            case 'G2':
                return "https://seeklogo.com/images/G/g2-logo-F87402EB23-seeklogo.com.png";
            case 'Capterra':
                return "https://d2oeplw15jeq9j.cloudfront.net/integrations/capterra.com.png";
            case 'ProductHunt':
                return "https://cdn-icons-png.flaticon.com/512/2111/2111581.png";
            case 'AppSumo':
                return "https://extremecouponingmom.ca/wp-content/uploads/2022/11/APPSUMO-Logo-2022.png";
            case 'BBB':
                return "https://upload.wikimedia.org/wikipedia/commons/thumb/3/31/Blogger.svg/2059px-Blogger.svg.png";
            case 'Gmail':
            case 'Email':
                return "https://static.vecteezy.com/system/resources/previews/022/484/516/non_2x/google-mail-gmail-icon-logo-symbol-free-png.png";
            default:
                return "https://static.thenounproject.com/png/4693713-200.png";
        }
    }
}
