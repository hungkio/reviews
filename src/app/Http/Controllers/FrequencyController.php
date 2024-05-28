<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FrequencyController extends Controller
{
    //
    public function index()
    {
        $account_id = Auth::user()->account_id;
        $result = DB::table('accounts')
            ->where('accounts_id', $account_id)
            ->first();

        return view('pages/apps.settings.frequency.list', compact('result'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $account_id = Auth::user()->account_id;

        $check_user = DB::table('accounts')
            ->where('accounts_id', $account_id)
            ->first();

        if ($check_user != null) {
            try {
                $data_update = [
                    'frequency' => $data['frequency'],
                    'updated_at' => Carbon::now(),
                ];
                DB::table('accounts')
                    ->where('accounts_id', $account_id)
                    ->update($data_update);
            } catch (\Exception $e) {
                echo "Error: " . $e->getMessage();
            }
        }

        return response()->json(['message' => 'Successfully updated'], 200);

    }

}
