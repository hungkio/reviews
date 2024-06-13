<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class FormManagementController extends Controller
{
    public function index()
    {
        return view('pages/apps.manage.form.index');
    }

    public function saveInformation(Request $request)
    {
        $account_id = Auth::user()->account_id;
        $username = $request->username;
        $email = $request->email;
        $customer_id = Uuid::uuid4()->toString();
        $this->insertCustomers($account_id, $customer_id, $username, $email);
        $this->insertPayment($account_id, $customer_id, $username, $email);
        return response()->json(['message' => 'Successfully updated', 'code' => 200], 200);

    }

    public function insertCustomers($account_id, $customer_id, $username, $email){
        try {
            $check_customers_exits = DB::table('customers')
                ->where('account_id', $account_id)
                ->where('customers_id', $customer_id)
                ->first();
            if(!$check_customers_exits){
                $data_insert = [
                    'account_id' => isset($account_id) ? $account_id : null,
                    'customers_id' => isset($customer_id) ? $customer_id : null,
                    'email' => isset($email) ? $email : null,
                    'name' => isset($username) ? $username : null,
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
            return response()->json(['message' => 'Something went wrong', 'code' => 500], 200);
            print_r($e);
        }
    }

    public function insertPayment($account_id, $customer_id, $username, $email){

        try {
            $count_payment = DB::table('payments')
                ->where('customer', $customer_id)
                ->count();
            $frequency = DB::table('accounts')
                ->where('accounts_id',$account_id)
                ->addSelect('frequency')
                ->first();

            if($frequency->frequency == 4){
                //Xử lý thay thế data
            }

            if($frequency->frequency == 5){
                $count_payment = DB::table('payments')
                    ->where('customer', $customer_id)
                    ->where('status_email' , '=', 'Sent')
                    ->count();
                if(!$count_payment){
                    $status_email = 'Scheduled';
                }
            }

            $data_insert = [
                'account_id' => isset($account_id) ? $account_id : null,
                'customers_id' => $customer_id,
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
                'status_email' => 'Scheduled',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
            DB::table('payments')->insert($data_insert);
        } catch (Exception $e) {
            return response()->json(['message' => 'Something went wrong', 'code' => 500], 200);
            print_r($e);
        }
    }
}
