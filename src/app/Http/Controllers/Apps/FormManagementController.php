<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
        $this->insertPayment($account_id, $customer_id);
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
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
                DB::table('customers')->insert($data_insert);
                Log::info(json_encode($data_insert));
            }
        } catch (Exception $e) {
            return response()->json(['message' => 'Something went wrong', 'code' => 500], 200);
            print_r($e);
        }
    }

    public function insertPayment($account_id, $customer_id){

        try {
            $count_payment = DB::table('payments')
                ->where('customer', $customer_id)
                ->count();
            $frequency = DB::table('accounts')
                ->where('accounts_id',$account_id)
                ->addSelect('frequency')
                ->first();

            $status_email = null;

            if ((!$frequency || !$frequency->frequency) || ($frequency->frequency == 1 && $count_payment == 0) ||
                ($frequency->frequency == 2 && $count_payment >= 1) ||
                ($frequency->frequency == 3 && $count_payment >= 2)) {
                $status_email = 'Scheduled';
            }
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

            Log::info(json_encode($frequency->frequency));
            $payment_intent_id = Uuid::uuid4()->toString();
            $data_insert = [
                'account_id' => isset($account_id) ? $account_id : null,
                'customers_id' => $customer_id,
                'object_id' => null,
                'payment_intent_id' => $payment_intent_id,
                'amount' => 0,
                'currency' => '',
                'status' => '',
                'customer' => $customer_id,
                'status_email' => $status_email,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
            Log::info(json_encode($data_insert));
            DB::table('payments')->insert($data_insert);
        } catch (Exception $e) {
            return response()->json(['message' => 'Something went wrong', 'code' => 500], 200);
            print_r($e);
        }
    }
}
