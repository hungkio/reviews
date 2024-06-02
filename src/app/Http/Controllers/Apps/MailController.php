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

        if($request->all()['type'] == 'demo'){
            $details = [
                'type' => 'demo',
                'data' => [
                    'order-id' => '$#187189',
                    'name' => 'Test send mail',
                    'email' => 'example@gmail.com',
                    'phone' => '0123456789',
                    'address' => 'Hoang Sa Truong Sa belongs to Viet Nam',
                    'content' => 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.',
                ],
            ];
            $email = isset($details['data']['email']) ? $details['data']['email'] : null;
        }

        if($request->all()['type'] == 'review'){
            $customer = json_decode('{"id":1,"customers_id":"cus_PogkFewKnKJ2G7","email":"nguyenthanhnamx3tv@gmail.com","name":"V\u01b0\u01a1ng Tr\u1ea7n","phone":"+18006156435","object":"customer","address":"{\"city\": \"Waseca\", \"line1\": \"111 North State Street\", \"line2\": \"\", \"state\": \"MN\", \"country\": \"US\", \"postal_code\": \"56093\"}","balance":0,"currency":"usd","default_source":null,"delinquent":0,"description":"Customer to test payment","discount":null,"invoice_prefix":"75640C26","invoice_settings":"{\"footer\": null, \"custom_fields\": null, \"rendering_options\": null, \"default_payment_method\": null}","metadata":"[]","next_invoice_sequence":1,"preferred_locales":"[\"en-US\"]","shipping":"{\"name\": \"V\u01b0\u01a1ng Tr\u1ea7n\", \"phone\": \"+18006156435\", \"address\": {\"city\": \"Waseca\", \"line1\": \"111 North State Street\", \"line2\": \"\", \"state\": \"MN\", \"country\": \"US\", \"postal_code\": \"56093\"}}","tax_exempt":"none","test_clock":null,"created_at":"2024-05-21 15:41:04","updated_at":"2024-05-21 15:41:04","account_id":"acct_1OyClyIyTqf0e7cM","status_email":"Scheduled"}');
            $details = [
                'type' => 'review',
                'data' => $customer,
                'rating_style' => 'stars'

            ];
            $email = isset($details['data']->email) ? $details['data']->email : null;
        }
        // Log::info(json_encode($request->all()['type']));


        if ($email) {
            Mail::to($email)->send(new ExampleMail($details));
        }
    }
    public function show(Request $request){
        $data = $request->all();
        $email = $request->query('email');
        $id_update = $request->query('id_update');
        $customer_id = $request->query('customer_id');
        $account_id = $request->query('account_id');
        $star = $request->query('star');
        $review = $request->query('review');
        return view('mails/rating-submit', compact('email','id_update','customer_id','star','review','account_id'));
    }
}
