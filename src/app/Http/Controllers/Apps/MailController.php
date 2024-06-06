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
            $payment = json_decode('{"id":1, "object_id":"event","payment_intent_id":"pi_3Oz4aZIyTqf0e7cM09acgKJW"}');
            $details= json_decode('{"type":"review","data":{"customers_id":"cus_PogkFewKnKJ2G7","email":"nguyenthanhnamx3tv@gmail.com","name":"V\u01b0\u01a1ng Tr\u1ea7n","phone":"+18006156435","address":"{\"city\": \"Waseca\", \"line1\": \"111 North State Street\", \"line2\": \"\", \"state\": \"MN\", \"country\": \"US\", \"postal_code\": \"56093\"}","account_id":"acct_1OyClyIyTqf0e7cM","id":1,"accounts_id":"acct_1OyClyIyTqf0e7cM","object":"account","capabilities":"{\"transfers\": \"inactive\", \"eps_payments\": \"inactive\", \"p24_payments\": \"inactive\", \"card_payments\": \"inactive\", \"link_payments\": \"inactive\", \"ideal_payments\": \"inactive\", \"affirm_payments\": \"inactive\", \"klarna_payments\": \"inactive\", \"cashapp_payments\": \"inactive\", \"giropay_payments\": \"inactive\", \"acss_debit_payments\": \"inactive\", \"bancontact_payments\": \"inactive\", \"cartes_bancaires_payments\": \"inactive\", \"afterpay_clearpay_payments\": \"inactive\", \"us_bank_account_ach_payments\": \"inactive\"}","charges_enabled":0,"country":"US","default_currency":"usd","details_submitted":"0","future_requirements":"{\"errors\": [], \"past_due\": [], \"alternatives\": [], \"currently_due\": [], \"eventually_due\": [], \"disabled_reason\": null, \"current_deadline\": null, \"pending_verification\": []}","payouts_enabled":0,"requirements":"{\"errors\": [], \"past_due\": [\"business_profile.mcc\", \"business_profile.product_description\", \"business_profile.support_phone\", \"business_profile.url\", \"external_account\", \"individual.address.city\", \"individual.address.line1\", \"individual.address.postal_code\", \"individual.address.state\", \"individual.dob.day\", \"individual.dob.month\", \"individual.dob.year\", \"individual.email\", \"individual.first_name\", \"individual.last_name\", \"individual.phone\", \"individual.ssn_last_4\", \"settings.payments.statement_descriptor\", \"tos_acceptance.date\", \"tos_acceptance.ip\"], \"alternatives\": [], \"currently_due\": [\"business_profile.mcc\", \"business_profile.product_description\", \"business_profile.support_phone\", \"business_profile.url\", \"external_account\", \"individual.address.city\", \"individual.address.line1\", \"individual.address.postal_code\", \"individual.address.state\", \"individual.dob.day\", \"individual.dob.month\", \"individual.dob.year\", \"individual.email\", \"individual.first_name\", \"individual.last_name\", \"individual.phone\", \"individual.ssn_last_4\", \"settings.payments.statement_descriptor\", \"tos_acceptance.date\", \"tos_acceptance.ip\"], \"eventually_due\": [\"business_profile.mcc\", \"business_profile.product_description\", \"business_profile.support_phone\", \"business_profile.url\", \"external_account\", \"individual.address.city\", \"individual.address.line1\", \"individual.address.postal_code\", \"individual.address.state\", \"individual.dob.day\", \"individual.dob.month\", \"individual.dob.year\", \"individual.email\", \"individual.first_name\", \"individual.id_number\", \"individual.last_name\", \"individual.phone\", \"individual.ssn_last_4\", \"settings.payments.statement_descriptor\", \"tos_acceptance.date\", \"tos_acceptance.ip\"], \"disabled_reason\": \"requirements.past_due\", \"current_deadline\": 1715622527, \"pending_verification\": []}","settings":"{\"branding\": {\"icon\": null, \"logo\": null, \"primary_color\": null, \"secondary_color\": null}, \"invoices\": {\"default_account_tax_ids\": null}, \"payments\": {\"statement_descriptor\": null, \"statement_descriptor_kana\": null, \"statement_descriptor_kanji\": null}, \"dashboard\": {\"timezone\": \"Etc\/UTC\", \"display_name\": null}, \"card_issuing\": {\"tos_acceptance\": {\"ip\": null, \"date\": null}}, \"card_payments\": {\"statement_descriptor_prefix\": null, \"statement_descriptor_prefix_kana\": null, \"statement_descriptor_prefix_kanji\": null}, \"bacs_debit_payments\": {\"display_name\": null, \"service_user_number\": null}, \"sepa_debit_payments\": []}","type":"standard","frequency":0,"created_at":"2024-05-22 17:49:56","updated_at":"2024-05-28 16:16:37","business_name":"Gto","website_url":"https:\/\/vi.wikipedia.org\/wiki\/B%C3%A1nh_t%C3%A9t","logo":null,"color":"#ce2c2c","from_email":"nam@gmail.com","reply_to_email":"nam@gmail.com"},"payment":{"id":1,"object_id":"event","payment_intent_id":"pi_3Oz4aZIyTqf0e7cM09acgKJW","object":"payment_intent","amount":600000,"amount_capturable":0,"amount_details":"{\"tip\": []}","amount_received":600000,"application":null,"currency":"usd","customer":"cus_PogkFewKnKJ2G7","description":"Payment for webhook","latest_charge":"ch_3Oz4aZIyTqf0e7cM0pIDkSLa","livemode":0,"metadata":"[]","payment_method":"pm_1Oz3NsIyTqf0e7cMEOzWLZhM","payment_method_types":"[\"card\"]","status":"succeeded","request_id":"pi_3Oz4aZIyTqf0e7cM09acgKJW","idempotency_key":null,"amount_details_tip":"{\"tip\": []}","application_fee_amount":null,"automatic_payment_methods":null,"canceled_at":null,"cancellation_reason":null,"capture_method":"automatic","client_secret":null,"confirmation_method":"automatic","invoice":null,"last_payment_error":null,"next_action":null,"on_behalf_of":null,"payment_method_configuration_details":null,"payment_method_options":"{\"card\": {\"network\": null, \"installments\": null, \"mandate_options\": null, \"request_three_d_secure\": \"automatic\"}}","processing":null,"receipt_email":null,"review":null,"setup_future_usage":null,"shipping":null,"source":null,"statement_descriptor":"payment","statement_descriptor_suffix":null,"transfer_data":null,"transfer_group":null,"pending_webhooks":null,"request":null,"type":null,"created_at":"2024-05-20 17:45:23","updated_at":"2024-05-20 17:45:23","account_id":null,"customers_id":null,"status_email":"Scheduled"},"reviewRequests":{"id":1,"account_id":"acct_1OyClyIyTqf0e7cM","interval_date":"1","interval_type":"days","rating_style":"stars","email_subject":"Hay l\u1eafm","email_body":"<p><img src=\"http:\/\/localhost:9000\/storage\/WaSFGiGoG1W2cqwbpKxz.jpeg\"><\/p><p><br><\/p><p>aaaaaaaa<\/p>","created_at":"2024-05-27 16:27:35","updated_at":"2024-05-27 16:27:35","record_number":null}}');
            // $details = [
            //     'type' => 'review',
            //     'data' => $payment,
            //     'email' => 'nguyenthanhnamx3tv@gmail.com',
            //     'rating_style' => 'stars'
            // ];
            // $details = [
            //     'type' => 'review',
            //     'data' => $customer,
            //     'payment' => $payment,
            //     'reviewRequests' => isset($reviewRequests[$i]) ? $reviewRequests[$i] : []
            // ];
            // $email = isset($details['email']) ? $details['email'] : null;
            $email = isset($details->data->email) ? $details->data->email : null;
        }
        // Log::info(json_encode($request->all()['type']));


        if ($email) {
            Mail::to($email)->send(new ExampleMail($details));
        }
    }
    public function show(Request $request){
        $data = $request->all();
        $payment_id = $request->query('payment_id');
        $star = $request->query('star');
        $review = $request->query('review');
        $email_body = $request->query('email_body');
        $background_color = $request->query('background_color');
        return view('mails/rating-submit', compact('payment_id','star','review','email_body','background_color'));
    }
}
