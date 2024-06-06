<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Mail\ExampleMail;
use Illuminate\Support\Facades\Mail;

class ReviewsController extends Controller
{
    public function index()
    {
        $get_account_id = Auth::user()->account_id;

        $result = DB::table('reviews')
            ->where('account_id', $get_account_id)
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

        $result = $result->map(function ($item, $key) use ($customerData) {
            $item->dateTime = $this->getDateTime($item->created_at);
            $item->userName = $customerData[$item->customer_id]['name'];
            return $item;
        });

        return view('pages/apps.manage.reviews.list', compact('result'));
    }

    public function updateStatus(Request $request)
    {
        $data = $request->all();
        try {
            DB::table('reviews')
                ->where('id', $data['id'])
                ->update(['status' => $data['status']]);
            return response()->json(['message' => 'Successfully updated', 'code' => 200], 200);
        } catch (Exception $e) {
            print_r($e);
            return response()->json(['message' => 'Something went wrong', 'code' => 500], 200);
        }
    }

    public function updateMultipleStatus(Request $request)
    {
        try {
            $data = $request->all();
            DB::table('reviews')
                ->whereIn('id', $data['review_ids'])
                ->update(['status' => $data['status']]);
            return response()->json(['message' => 'Successfully updated', 'code' => 200], 200);
        } catch (Exception $e) {
            print_r($e);
            return response()->json(['message' => 'Something went wrong', 'code' => 500], 200);
        }
    }

    public function updateOrder(Request $request)
    {
        $data = $request->all();
        try {
            $review = DB::table('reviews')
                ->where('id', $data['id'])
                ->first();

            if ($review->order == 1) {
                DB::table('reviews')->where('id', $data['id'])->update(['order' => 0]);
            } else {
                DB::table('reviews')->where('id', $data['id'])->update(['order' => 1]);
            }

            return response()->json(['message' => 'Successfully updated', 'code' => 200], 200);
        } catch (Exception $e) {
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
        $data = $request->all();

        $payment_id = $data['payment_id'];

        $payment = DB::table('customers')
            ->join('payments', 'customers.customers_id', 'payments.customer')
            ->join('accounts', 'customers.account_id', '=', 'accounts.accounts_id')
            ->join('setting_review_destination', 'customers.account_id', '=', 'setting_review_destination.account_id')
            ->where('payments.payment_intent_id', $payment_id)
            ->select(
                'customers.email',
                'customers.name',
                'customers.phone',
                'customers.customers_id',
                'customers.account_id',
                'payments.payment_intent_id',
                'accounts.reply_to_email',
                'setting_review_destination.url',
                'setting_review_destination.send_notice'
            )
            ->first();

        if (!$payment) {
            return [];
        }
        $payment->review = $data['review'];
        $payment->star = $data['star'];

        $data_insert = [
            'star' => $data['star'],
            'review' => $data['review'],
            'customer_id' => $payment->customers_id,
            'account_id' => $payment->account_id,
            'source' => 'Email',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
        try {
            DB::table('reviews')->insert($data_insert);
            if ($data['star'] > 3 && isset($payment->url)) {
            } else {
                $details = [
                    'type' => 'feedback',
                    'data' => $payment,
                ];
                if ($payment && isset($payment->reply_to_email) && isset($payment->send_notice) && $payment->send_notice) {
                    Mail::to($payment->reply_to_email)->send(new ExampleMail($details));
                }
            }
            return redirect()->away($payment->url);
        } catch (Exception $e) {
            print_r($e);
        }
    }
}
