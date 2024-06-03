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
        $get_account_id = Auth::user()->account_id;

        $result = DB::table('reviews')
            ->where('account_id',$get_account_id )
            ->orderByDesc('order')
            ->get();

        $customerIds = $result->pluck('customer_id')->unique()->values()->all();

        $customers = DB::table('customers')
            ->whereIn('customers_id', $customerIds)
            ->get();

        $customerData = [];
        foreach ($customers as $customer) {
            $customerData[$customer->customers_id] = ['name' => $customer->name, 'email' => $customer->email];
        }

        $result = $result->map(function ($item, $key) use($customerData) {
            $item->dateTime = $this->getDateTime($item->created_at);
            $item->userName = $customerData[$item->customer_id]['name'];
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

    public function updateMultipleStatus(Request $request){
        try {
            $data = $request->all();
            DB::table('reviews')
                ->whereIn('id', $data['review_ids'])
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

    public function getDateTime($time)
    {
        $oldDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $time);
        $currentDateTime = Carbon::now();
        $minutesDifference = $oldDateTime->diffInMinutes($currentDateTime);
        if ($minutesDifference < 60) {
            return $minutesDifference . ' minutes ago';
        }
        $hoursDifference = $oldDateTime->diffInHours($currentDateTime);
        if ($hoursDifference < 24) {
            return $hoursDifference . ' hours ago';
        }
        $daysDifference = $oldDateTime->diffInDays($currentDateTime);
        return $daysDifference . ' days ago';

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
