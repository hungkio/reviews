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
    // public function sendEmail(Request $request)
    public function sendEmail($emailOrder = null)
    {
        $payments = DB::table('payments')
            ->where('status_email', '<>' ,'Canceled')
            ->whereNotNull('status_email')
            ->orderBy('customer')
            ->get()
            ->groupBy('customer');
        $sentEmails = [];
        foreach ($payments as $customer_id => $payment_value) {
            $customer = DB::table('customers')
                ->select('customers.customers_id', 'customers.email', 'customers.name', 'customers.phone', 'customers.address', 'customers.account_id', 'accounts.*')
                ->join('accounts', 'customers.account_id', '=', 'accounts.accounts_id')
                ->where('customers.customers_id', $customer_id)
                ->first();


            if ($customer) {
                $reviewRequests = DB::table('review_request')
                    ->where('account_id', $customer->account_id)
                    ->orderByDesc('record_number')
                    ->get();
                foreach ($payment_value as $payment) {
                    $sentEmails = array_merge($sentEmails, $this->handleSendEmail($customer, $reviewRequests, $payment, $emailOrder));
                }
            }
        }
        return view('mails.send-mail', ['sentEmails' => $sentEmails]);
    }

    private function handleSendEmail($customer, $reviewRequests, $payment, $emailOrder = null)
    {
        $email = $customer->email;
        $sentEmails = [];
        if ($email) {
            if ($emailOrder) {
                if (isset($reviewRequests[$emailOrder - 1])) {
                    $details = [
                        'type' => 'review',
                        'data' => $customer,
                        'payment' => $payment,
                        'reviewRequests' => $reviewRequests[$emailOrder - 1]
                    ];
                    Mail::to($email)->send(new ExampleMail($details));
                    DB::table('payments')->where('id', $payment->id)->update([
                        'status_email' => 'Sent',
                        'updated_at' => Carbon::now()
                    ]);
                    $sentEmails[] = $details;
                }
            } else {
                for ($i = 0; $i < count($reviewRequests); $i++) {
                    $details = [
                        'type' => 'review',
                        'data' => $customer,
                        'payment' => $payment,
                        'reviewRequests' => isset($reviewRequests[$i]) ? $reviewRequests[$i] : []
                    ];

                    Mail::to($email)->send(new ExampleMail($details));
                    DB::table('payments')->where('id', $payment->id)->update([
                        'status_email' => 'Sent',
                        'updated_at' => Carbon::now()
                    ]);
                    $sentEmails[] = $details;
                }
            }
        }
        return $sentEmails;

    }
    public function show(Request $request)
    {
        $data = $request->all();
        $payment_id = $request->query('payment_id');
        $payment_intent_id = $request->query('payment_intent_id');
        $star = $request->query('star');
        $review = $request->query('review');
        $email_body = $request->query('email_body');
        $background_color = $request->query('background_color');
        return view('mails/rating-submit', compact('payment_intent_id', 'payment_id', 'star', 'review', 'email_body', 'background_color'));
    }
}
