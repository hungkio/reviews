<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QueueManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $get_account_id = Auth::user()->account_id;

        $get_data = DB::table('payments')
            ->where('account_id',$get_account_id )
            ->get();

        $result = [];

        foreach ($get_data->all() as $payment_record){
            $customer_record = DB::table('customers')
                ->where('account_id',$get_account_id )
                ->where('customers_id',$payment_record->customer )
                ->first();

            $data = [
                'name' => $customer_record->name,
                'email' => $customer_record->email,
                'payment_intent_id' => $payment_record->payment_intent_id
            ];
            array_push($result, $data);
        }
        return view('pages/apps.manage.queue.list', compact('result'));
    }
}
