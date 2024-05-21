<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Services\PayUService\Exception;

class StripeController extends Controller
{
    //
    public function getDataStripe(){
        // $json = file_get_contents('php://input');
        // $payload = json_decode($json, true);
        $payload = '{
            "id": "evt_3Oz4aZIyTqf0e7cM0tK5UPzL",
            "object": "event",
            "account": "acct_1OyClyIyTqf0e7cM",
            "api_version": "2023-10-16",
            "created": 1711577096,
            "data": {
                "object": {
                    "id": "pi_3Oz4aZIyTqf0e7cM09acgKJW",
                    "object": "payment_intent",
                    "amount": 600000,
                    "amount_capturable": 0,
                    "amount_details": {
                        "tip": []
                    },
                    "amount_received": 600000,
                    "application": null,
                    "application_fee_amount": null,
                    "automatic_payment_methods": null,
                    "canceled_at": null,
                    "cancellation_reason": null,
                    "capture_method": "automatic",
                    "client_secret": null,
                    "confirmation_method": "automatic",
                    "created": 1711577095,
                    "currency": "usd",
                    "customer": "cus_PogkFewKnKJ2G7",
                    "description": "Payment for webhook",
                    "invoice": null,
                    "last_payment_error": null,
                    "latest_charge": "ch_3Oz4aZIyTqf0e7cM0pIDkSLa",
                    "livemode": false,
                    "metadata": [],
                    "next_action": null,
                    "on_behalf_of": null,
                    "payment_method": "pm_1Oz3NsIyTqf0e7cMEOzWLZhM",
                    "payment_method_configuration_details": null,
                    "payment_method_options": {
                        "card": {
                            "installments": null,
                            "mandate_options": null,
                            "network": null,
                            "request_three_d_secure": "automatic"
                        }
                    },
                    "payment_method_types": [
                        "card"
                    ],
                    "processing": null,
                    "receipt_email": null,
                    "review": null,
                    "setup_future_usage": null,
                    "shipping": null,
                    "source": null,
                    "statement_descriptor": "payment",
                    "statement_descriptor_suffix": null,
                    "status": "succeeded",
                    "transfer_data": null,
                    "transfer_group": null
                }
            },
            "livemode": false,
            "pending_webhooks": 0,
            "request": {
                "id": "req_XeXAb59TT1BSKW",
                "idempotency_key": "0d31a1f0-a69f-4f27-a8ff-c38d852e27d7"
            },
            "type": "payment_intent.succeeded"
        }';

        $paymentData = json_decode($payload);
        if ($paymentData && isset($paymentData->data) && isset($paymentData->data->object)) {
            $data = $paymentData->data;
            $object = $data->object;
        
            $account_id = $paymentData->account ?? null;
            $payment_id = $object->id ?? null;
            $customer_id = $object->customer ?? null;
        
            $this->insertPayment($paymentData, $object, $data);

            $stripe = new \Stripe\StripeClient('sk_test_51Oyz3vHGEde3YLOc00eCULJJXYHWAzCN3B0QYN54DpCOBBTxUMu5BnlUJfb1WvOC6dk9SfdEwHbpUJ45aoJuRXwT00TwqVF7Zl');
            try {
                $customers = $stripe->customers->retrieve($customer_id, [], ['stripe_account' => $account_id]);
                $accounts = $stripe->accounts->retrieve($account_id, []);
                $this->insertUsers($customers, $account_id);
                $this->insertCustomers($customers, $account_id);
                $this->insertAccount($accounts);
            
            } catch(\UnexpectedValueException $e) {
                print_r($e);
            } catch(\Stripe\Exception\SignatureVerificationException $e) {
                print_r($e);
            }
            return response()->json(['message' => 'Payment successfully saved'], 201);
        }
    }

    public function insertPayment($paymentData, $object, $data){
        try {
            $data_insert = [
                'account_id' => isset($paymentData->account) ? $paymentData->account : null,
                'object_id' => isset($paymentData->object) ? $paymentData->object : null,
                'payment_intent_id' => isset($object->id) ? $object->id : null,
                'object' => isset($object->object) ? $object->object : null,
                'amount' => isset($object->amount) ? $object->amount : null,
                'amount_capturable' => isset($object->amount_capturable) ? $object->amount_capturable : null,
                'amount_details' => isset($object->amount_details) ? json_encode($object->amount_details) : null,
                'amount_received' => isset($object->amount_received) ? $object->amount_received : null,
                'application' => isset($object->application) ? $object->application : null,
                'currency' => isset($object->currency) ? $object->currency : null,
                'customer' => isset($object->customer) ? $object->customer : null,
                'description' => isset($object->description) ? $object->description : null,
                'latest_charge' => isset($object->latest_charge) ? $object->latest_charge : null,
                'livemode' => isset($object->livemode) ? $object->livemode : false,
                'metadata' => isset($object->metadata) ? json_encode($object->metadata) : null,
                'payment_method' => isset($object->payment_method) ? $object->payment_method : null,
                'payment_method_types' => isset($object->payment_method_types) ? json_encode($object->payment_method_types) : null,
                'status' => isset($object->status) ? $object->status : null,
                'request_id' => isset($object->id) ? $object->id : null,
                'idempotency_key' => isset($object->idempotency_key) ? $object->idempotency_key : null,
                'amount_details_tip' => isset($object->amount_details) ? json_encode($object->amount_details) : null,
                'application_fee_amount' => isset($object->application_fee_amount) ? $object->application_fee_amount : null,
                'automatic_payment_methods' => isset($object->automatic_payment_methods) ? $object->automatic_payment_methods : null,
                'canceled_at' => isset($object->canceled_at) ? $object->canceled_at : null,
                'cancellation_reason' => isset($object->cancellation_reason) ? $object->cancellation_reason : null,
                'capture_method' => isset($object->capture_method) ? $object->capture_method : null,
                'client_secret' => isset($object->client_secret) ? $object->client_secret : null,
                'confirmation_method' => isset($object->confirmation_method) ? $object->confirmation_method : null,
                'invoice' => isset($object->invoice) ? $object->invoice : null,
                'last_payment_error' => isset($object->last_payment_error) ? $object->last_payment_error : null,
                'next_action' => isset($object->next_action) ? $object->next_action : null,
                'on_behalf_of' => isset($object->on_behalf_of) ? $object->on_behalf_of : null,
                'payment_method_configuration_details' => isset($object->payment_method_configuration_details) ? $object->payment_method_configuration_details : null,
                'payment_method_options' => isset($object->payment_method_options) ? json_encode($object->payment_method_options) : null,
                'processing' => isset($object->processing) ? $object->processing : null,
                'receipt_email' => isset($object->receipt_email) ? $object->receipt_email : null,
                'review' => isset($object->review) ? $object->review : null,
                'setup_future_usage' => isset($object->setup_future_usage) ? $object->setup_future_usage : null,
                'shipping' => isset($object->shipping) ? $object->shipping : null,
                'source' => isset($object->source) ? $object->source : null,
                'statement_descriptor' => isset($object->statement_descriptor) ? $object->statement_descriptor : null,
                'statement_descriptor_suffix' => isset($object->statement_descriptor_suffix) ? $object->statement_descriptor_suffix : null,
                'transfer_data' => isset($object->transfer_data) ? $object->transfer_data : null,
                'transfer_group' => isset($object->transfer_group) ? $object->transfer_group : null,
                'pending_webhooks' => isset($data->pending_webhooks) ? $data->pending_webhooks : null,
                'request' => isset($data->request) ? json_encode($data->request) : null,
                'type' => isset($data->type) ? $data->type : null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
            DB::table('payments')->insert($data_insert);
        } catch (Exception $e) {
            print_r($e);
        }
    }
    
    public function insertCustomers($customers, $account_id){
        try {
            $check_customers_exits = DB::table('customers')
                                ->where('account_id', $account_id)
                                ->where('customers_id', $customers->id)
                                ->first();
            if(!$check_customers_exits){
                $data_insert = [
                    'account_id' => isset($account_id) ? $account_id : null,
                    'customers_id' => isset($customers->id) ? $customers->id : null,
                    'email' => isset($customers->email) ? $customers->email : null,
                    'name' => isset($customers->name) ? $customers->name : null,
                    'phone' => isset($customers->phone) ? $customers->phone : null,
                    'object' => isset($customers->object) ? $customers->object : null,
                    'address' => isset($customers->address) ? json_encode($customers->address) : null,
                    'balance' => isset($customers->balance) ? $customers->balance : null,
                    'currency' => isset($customers->currency) ? $customers->currency : null,
                    'default_source' => isset($customers->default_source) ? $customers->default_source : null,
                    'delinquent' => isset($customers->delinquent) ? $customers->delinquent : false,
                    'description' => isset($customers->description) ? $customers->description : null,
                    'discount' => isset($customers->discount) ? $customers->discount : null,
                    'invoice_prefix' => isset($customers->invoice_prefix) ? $customers->invoice_prefix : null,
                    'invoice_settings' => isset($customers->invoice_settings) ? json_encode($customers->invoice_settings) : null,
                    'metadata' => isset($customers->metadata) ? json_encode($customers->metadata) : null,
                    'next_invoice_sequence' => isset($customers->next_invoice_sequence) ? $customers->next_invoice_sequence : null,
                    'preferred_locales' => isset($customers->preferred_locales) ? json_encode($customers->preferred_locales) : null,
                    'shipping' => isset($customers->shipping) ? json_encode($customers->shipping) : null,
                    'tax_exempt' => isset($customers->tax_exempt) ? $customers->tax_exempt : null,
                    'test_clock' => isset($customers->test_clock) ? $customers->test_clock : null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
                DB::table('customers')->insert($data_insert);
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }
    public function insertAccount($accounts){
        try {
            $check_accounts_exits = DB::table('accounts')
                                ->where('accounts_id', $accounts->id)
                                ->first();
            if(!$check_accounts_exits){
                $data_insert = [
                    'accounts_id' => isset($accounts->id) ? $accounts->id : null,
                    'object' => isset($accounts->object) ? $accounts->object : null,
                    'capabilities' => isset($accounts->capabilities) ? json_encode($accounts->capabilities) : null,
                    'charges_enabled' => isset($accounts->charges_enabled) ? $accounts->charges_enabled : false,
                    'country' => isset($accounts->country) ? $accounts->country : null,
                    'default_currency' => isset($accounts->default_currency) ? $accounts->default_currency : null,
                    'details_submitted' => isset($accounts->details_submitted) ? $accounts->details_submitted : false,
                    'future_requirements' => isset($accounts->future_requirements) ? json_encode($accounts->future_requirements) : null,
                    'payouts_enabled' => isset($accounts->payouts_enabled) ? $accounts->payouts_enabled : false,
                    'requirements' => isset($accounts->requirements) ? json_encode($accounts->requirements) : null,
                    'settings' => isset($accounts->settings) ? json_encode($accounts->settings) : null,
                    'type' => isset($accounts->type) ? $accounts->type : null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
                DB::table('accounts')->insert($data_insert);
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }

    public function insertUsers($customers , $account_id){
        try {
            $check_user_exits = DB::table('users')
                                ->where('account_id', $account_id)
                                ->first();
            if(!$check_user_exits){
                $random_password = Str::random(10);
                $hashed_password = Hash::make($random_password);

                $data_insert = [
                    'name'              => isset($customers->name) ? $customers->name : null,
                    'email'             => isset($customers->email) ? $customers->email : null,
                    'password'          => $hashed_password,
                    'type'              => 'stripe',
                    'account_id'        => $account_id,
                    'email_verified_at' => Carbon::now(),
                ];
                DB::table('users')->insert($data_insert);
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }

}
