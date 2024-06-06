<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
                'id' => $payment_record->id,
                'name' => $customer_record->name,
                'email' => $customer_record->email,
                'payment_intent_id' => $payment_record->payment_intent_id,
                'status' => $payment_record->status_email,
                'created_at' => Carbon::parse($payment_record->created_at)->format('d/m/Y'),
            ];
            array_push($result, $data);
        }
        return view('pages/apps.manage.queue.list', compact('result'));
    }

    public function updateStatus(Request $request){
        $data = $request->all();
        try {
        DB::table('payments')
            ->where('id',$data['id'] )
            ->update(['status_email' => $data['status']]);
            return response()->json(['message' => 'Successfully updated', 'code' => 200], 200);
        }catch (Exception $e) {
            print_r($e);
            return response()->json(['message' => 'Something went wrong', 'code' => 500], 200);
        }
    }
}
