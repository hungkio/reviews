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
        $accounts = DB::table('accounts')->get();

        foreach ($accounts as $account) {
            $frequency = $account->frequency;
            $customers = DB::table('customers')
                            ->where('account_id', $account->accounts_id)
                            ->distinct('customers_id')
                            ->get();
            $reviewRequests = DB::table('review_request')
                                ->where('account_id', $account->accounts_id)
                                ->orderByDesc('record_number')
                                ->get();

            foreach ($customers as $customer) {
                $payments = DB::table('payments')->where('customers_id', $customer->customers_id)->count();
                
                switch ($frequency) {
                    case 0:
                    // case 'Mỗi khoản thanh toán':
                        $this->sendEmail($customer, $reviewRequests);
                        break;

                    case 1:
                    // case 'Chỉ thanh toán lần đầu':
                        if ($payments == 1) {
                            Log::info('1');
                            $this->sendEmail($customer, $reviewRequests);
                        }
                        break;

                    // case 'Bỏ qua khoản thanh toán đầu tiên, gửi từ lần thứ hai trở đi':
                    case 2:
                        if ($payments > 1) {
                            Log::info('2');
                            $this->sendEmail($customer, $reviewRequests);
                        }
                        break;

                    case 3:
                    // case 'Bỏ qua hai khoản thanh toán đầu tiên, gửi từ lần thanh toán thứ ba trở đi':
                        if ($payments > 2) {
                            Log::info('3');
                            $this->sendEmail($customer, $reviewRequests);
                        }
                        break;

                    // case 'Thanh toán thay thế':
                    case 4:
                        Log::info('4');
                        // if ($payments % 2 == 0) {
                        //     $this->sendEmail($customer);
                        // }
                        break;

                    // case 'Bỏ qua khách hàng khi đánh giá đã được gửi trước đó':
                    case 5:
                        if ($this->hasNotReceivedReviewRequest($customer)) {
                            $this->sendEmail($customer, $reviewRequests);
                        }
                        break;
                }
            }

        }
    }

    private function sendEmail($customer , $reviewRequests)
    {
        $email = $customer->email;
        $now = Carbon::now()->format('Y-m-d');
        
        for($i = 0 ; $i < count($reviewRequests) ; $i++){
            $created_at = new Carbon($customer->created_at);
            $interval_date = 0;
            if($i == 0 ){
                $interval_date = $reviewRequests[0]->interval_date;
            }else{
                $interval_date = $reviewRequests[$i]->interval_date + $reviewRequests[$i - 1]->interval_date;
            }
            $date_send = $created_at->copy()->addDays($interval_date)->format('Y-m-d');
            Log::info('date_send');
            Log::info(json_encode($date_send));
            Log::info('now');
            Log::info(json_encode($now));
            if(($now == $date_send) && $email){
                $details = [
                    'type' => 'review',
                    'data' => $customer,
                    'rating_style' => isset($reviewRequests[$i]->rating_style) ? $reviewRequests[$i]->rating_style : 'stars'
                ];
                Mail::to($email)->send(new ExampleMail($details));
                DB::table('customers')->where('id' , $customer->id)->update([
                    'status_email' => 'Sent',
                    'updated_at' => Carbon::now()
                ]);
            }
        }

    }


    private function hasNotReceivedReviewRequest($customer)
    {
        $reviewRequest = DB::table('reviews')
                            ->where('customers_id', $customer->customers_id)
                            ->first();

        return is_null($reviewRequest);
    }

}
