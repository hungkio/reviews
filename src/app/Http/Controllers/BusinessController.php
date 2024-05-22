<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BusinessController extends Controller
{
    //
    public function index()
    {
        return view('pages/apps.business.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'business_name' => 'required|string|max:255',
            'logo' => 'nullable|image|max:2048',
            'website_url' => 'required|url',
            'color' => 'nullable|string|max:7',
            'from_email' => 'required|email',
            'reply_to_email' => 'nullable|email'
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['logo'] = $request->file('image')->store('images', 'public');
        }

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
            DB::table('business')->insert($data_insert);
        } catch (Exception $e) {
            print_r($e);
        }
        
        return redirect()->back()->with('success', 'Business information saved successfully!');
    }
}

