<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReviewsController extends Controller
{
    public function index()
    {
//        $get_account_id = Auth::user()->account_id;

        $get_account_id = 'user_123';

        $result = DB::table('reviews')
            ->where('account_id',$get_account_id )
            ->get();

        return view('pages/apps.manage.reviews.list', compact('result'));
    }
}
