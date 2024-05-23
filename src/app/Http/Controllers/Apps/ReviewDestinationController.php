<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\isNull;

class ReviewDestinationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $get_account_id = Auth::user()->account_id;
        $result = DB::table('setting_review_destination')
            ->where('account_id', $get_account_id)
            ->first();

        return view('pages/apps.settings.review-destination.list', compact('result'));
    }

    public function saveSetting(Request $request)
    {
        $data = $request->all();
        $get_account_id = Auth::user()->account_id;

        $check_user = DB::table('setting_review_destination')
            ->where('account_id', $get_account_id)
            ->first();

        if ($check_user == null) {
            try {
                $data_insert = [
                    'account_id' => $get_account_id,
                    'social' => $data['social'],
                    'username' => $data['username'],
                    'url' => $data['url'],
                    'send_notice' => $data['send_notice'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];

                DB::table('setting_review_destination')->insert($data_insert);
            } catch (\Exception $e) {
                echo "Error: " . $e->getMessage();
            }

        } else {
            try {
                $data_update = [
                    'social' => $data['social'],
                    'username' => $data['username'],
                    'url' => $data['url'],
                    'send_notice' => $data['send_notice'],
                    'updated_at' => Carbon::now(),
                ];
                DB::table('setting_review_destination')
                    ->where('account_id', $get_account_id)
                    ->update($data_update);
            } catch (\Exception $e) {
                echo "Error: " . $e->getMessage();
            }
        }

        return response()->json(['message' => 'Successfully updated'], 200);


    }

}
