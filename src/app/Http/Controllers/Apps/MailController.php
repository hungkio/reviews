<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Mail\ExampleMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class MailController extends Controller
{
    public function sendEmail(Request $request)
    {
        $id = $request->id;

        $payment = DB::table('payments')->where('id',$id)->first();
        if(!$payment){
            return [];
        }

        $customer = DB::table('customers')
                ->select('customers.customers_id', 'customers.email', 'customers.name', 'customers.phone', 'customers.address', 'customers.account_id', 'accounts.*')
                ->join('accounts', 'customers.account_id', '=', 'accounts.accounts_id')
                ->where('customers.customers_id', $payment->customer)
                ->first();
        if ($customer) {
            $reviewRequests = DB::table('review_request')
                ->where('account_id', $customer->account_id)
                ->orderByDesc('record_number')
                ->first();
            $details = [
                'type' => 'review',
                'data' => $customer,
                'payment' => $payment,
                'reviewRequests' => $reviewRequests ? $reviewRequests : []
            ];
            $email = $customer->email;
            Mail::to($email)->send(new ExampleMail($details));
        }
    }
    public function show(Request $request){
        $data = $request->all();
        $payment_id = $request->query('payment_id');
        $payment_intent_id = $request->query('payment_intent_id');
        $star = $request->query('star');
        $review = $request->query('review');
        $email_body = $request->query('email_body');
        $background_color = $request->query('background_color');
        return view('mails/rating-submit', compact('payment_intent_id','payment_id','star','review','email_body','background_color'));
    }
}
