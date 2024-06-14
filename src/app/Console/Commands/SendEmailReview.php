<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Mail\ExampleMail;
use Illuminate\Support\Facades\Log;

class SendEmailReview extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send-review-requests';
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $payments = DB::table('payments')
            // ->where('status_email', 'Scheduled')
            ->orderBy('customer')
            ->get()
            ->groupBy('customer');
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
                    $this->sendEmail($customer, $reviewRequests, $payment);
                }
            }
        }
    }

    private function sendEmail($customer, $reviewRequests, $payment)
    {
        $email = $customer->email;
        $now = Carbon::now()->format('Y-m-d');

        for ($i = 0; $i < count($reviewRequests); $i++) {
            $created_at = new Carbon($payment->created_at);
            $interval_date = 0;
            if ($i == 0) {
                $interval_date = $reviewRequests[0]->interval_date;
            } else {
                $interval_date = 0;
                for ($j = 0; $j <= $i; $j++) {
                    $interval_date += $reviewRequests[$j]->interval_date;
                }
            }
            $date_send = $created_at->copy()->addDays($interval_date)->format('Y-m-d');
            if (($now == $date_send) && $email) {
                $details = [
                    'type' => 'review',
                    'data' => $customer,
                    'payment' => $payment,
                    'reviewRequests' => isset($reviewRequests[$i]) ? $reviewRequests[$i] : []
                ];
                
                Mail::to($email)->send(new ExampleMail($details));
                DB::table('payments')->where('id' , $payment->id)->update([
                    'status_email' => 'Sent',
                    'updated_at' => Carbon::now()
                ]);
            }
        }
    }
}
