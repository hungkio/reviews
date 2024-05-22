<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BusinessController extends Controller
{
    //
    public function index()
    {

        $user = Auth::user();
        $business = DB::table('accounts')
                            ->addSelect('business_name')
                            ->addSelect('website_url')
                            ->addSelect('logo')
                            ->addSelect('color')
                            ->addSelect('from_email')
                            ->addSelect('reply_to_email')
                            ->where('accounts_id',$user->account_id)
                            ->first();
        return view('pages/apps.business.index', compact('business'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'business_name' => 'required|string|max:255',
            'logo' => 'nullable|image|max:2048',
            'website_url' => 'required|url',
            'color' => 'nullable|string|max:7',
            'from_email' => 'required|email',
            'reply_to_email' => 'nullable|email'
        ]);

        $data = $request->all();

        if($request->hasFile('logo')){
            try {
                $storedPath = Storage::putFile('public', $request->file('logo'));
                $data['logo'] = Storage::url($storedPath);
            } catch (Exception $e) {
            }
        } 
        $check_exits = DB::table('accounts')
                       ->where('accounts_id',$user->account_id)
                       ->first();

        $data_insert = [
            'business_name' => $data['business_name'],
            'website_url' => $data['website_url'],
            'logo' => $data['logo'],
            'color' => $data['color'],
            'from_email' => $data['from_email'],
            'reply_to_email' => $data['reply_to_email'],
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];

        try {
            if(!$check_exits){
                $data_insert['created_at'] = Carbon::now();
                DB::table('accounts')->insert($data_insert);
            }else{
                DB::table('accounts')->where('accounts_id',$user->account_id)->update($data_insert);
            }
        } catch (Exception $e) {
            print_r($e);
        }
        
        return redirect()->back()->with('success', 'Business information saved successfully!');
    }
}
