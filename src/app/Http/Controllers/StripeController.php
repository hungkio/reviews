<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StripeController extends Controller
{
    //
    public function getDataStripe(){
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
        $data = $paymentData->data;
        $object = $data->object;
        if ($paymentData) {
            $data = isset($paymentData->data) ? $paymentData->data : null;
            if ($data) {
                $object = isset($data->object) ? $data->object : null;
                
                if ($object) {
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
                }
            }
        }


      
        return response()->json(['message' => 'Payment successfully saved'], 201);
    }

}
