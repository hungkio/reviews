<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReviewsController extends Controller
{
    public function index()
    {
//        $get_account_id = Auth::user()->account_id;

        $get_account_id = 'user_123';

        $result = DB::table('reviews')
            ->where('account_id',$get_account_id )
            ->orderByDesc('order')
            ->get();

        $result = $result->map(function ($item, $key) {
            $item->dateTime = $this->getDateTime($item->created_at);
            $item->userName = 'David Jameson';
            return $item;
        });

        return view('pages/apps.manage.reviews.list', compact('result'));
    }

    public function updateStatus(Request $request){
        $data = $request->all();
        try {
            DB::table('reviews')
                ->where('id', $data['id'])
                ->update(['status' => $data['status']]);
            return response()->json(['message' => 'Successfully updated', 'code' => 200], 200);
        }catch (Exception $e) {
            print_r($e);
            return response()->json(['message' => 'Something went wrong', 'code' => 500], 200);
        }
    }

    public function updateOrder(Request $request){
        $data = $request->all();
        try {
            $review = DB::table('reviews')
                ->where('id', $data['id'])
                ->first();

            if($review->order == 1){
                DB::table('reviews')->where('id', $data['id'])->update(['order'=> 0]);
            }else{
                DB::table('reviews')->where('id', $data['id'])->update(['order'=> 1]);
            }

            return response()->json(['message' => 'Successfully updated', 'code' => 200], 200);
        }catch (Exception $e) {
            print_r($e);
            return response()->json(['message' => 'Something went wrong', 'code' => 500], 200);
        }

    }

    public function getDateTime($date)
    {
        $pastTime = Carbon::parse($date);
        $currentTime = Carbon::now();

        $differenceInMinutes = $currentTime->diffInMinutes($pastTime);

        if ($differenceInMinutes < 60) {
            $result = $differenceInMinutes . ' minutes';
        } elseif ($differenceInMinutes < 1440) {
            $hours = floor($differenceInMinutes / 60);
            $minutes = $differenceInMinutes % 60;
            $result = $hours . ' hours ' . $minutes . ' minutes';
        } else {
            $days = floor($differenceInMinutes / 1440);
            $hours = floor(($differenceInMinutes % 1440) / 60);
            $result = $days . ' days ' . $hours . ' hours';
        }

        return $result;
    }
    
    public function insertReview(Request $request)
    {
        $data= $request->all();

        $data_insert = [
            'star' => $data['star'],
            'review' => $data['review'],
            'customer_id' => $data['customer_id'],
            'account_id' => $data['account_id'],
            'source' => 'Email',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];

        try {
            DB::table('reviews')->insert($data_insert);
            if ($data['star'] > 3) {
                return redirect()->away('https://www.youtube.com/');
            }else{
                // send email
            }

        } catch (Exception $e) {
            print_r($e);
        }
    }
}
