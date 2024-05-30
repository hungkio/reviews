<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ReviewRequestController extends Controller
{
    //

    public function index()
    {
        $account_id = Auth::user()->account_id;

        $templates = DB::table('review_request')
            ->where('account_id',$account_id)
            ->get();

        return view('pages/apps.review-request.index', compact('templates'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'interval_date' => 'required',
            'interval_type' => 'required',
            'rating_style' => 'required',
            'email_subject' => 'required',
            'email_body' => 'required',
        ]);
        $pattern = '/<img[^>]+src="data:image\/[^;]+;base64,([^">]+)"[^>]*>/i';

        if( !isset($request->email_body)){
            return [];
        }

        preg_match_all($pattern, $request->email_body, $matches);

        if (isset($matches[1])) {
            $base64_images = $matches[1];
            $fileExtension = 'jpeg';
            foreach ($base64_images as $base64_image) {
                $filename = Str::random(20) . '.' . $fileExtension;
                $storagePath = "public/" . $filename;
                Storage::put($storagePath, base64_decode($base64_image));
                $image = Storage::url($storagePath);
                $request['email_body'] = preg_replace($pattern, '<img src="' .  url('/') . $image . '">', $request->email_body, 1);
            }
        }

        $user = Auth::user();
        $account_id = $user->account_id;


        $count_email = DB::table('review_request')
                       ->where('account_id',$user->account_id)
                       ->count();
        if($count_email < 4){
            $data_insert = [
                'account_id' => $account_id,
                'interval_date' => $request['interval_date'],
                'interval_type' => $request['interval_type'],
                'rating_style' => $request['rating_style'],
                'email_subject' => $request['email_subject'],
                'email_body' => $request['email_body'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            try {
                $new_template_id = DB::table('review_request')->insertGetId($data_insert);
            } catch (Exception $e) {
                print_r($e);
            }
        }else{
            return response()->json(['message' => 'Do not save more than 4 samples', 'code' => 500], 200);
        }

        return response()->json(['message' => 'Successfully updated', 'code'=> 200, 'template_id' => $new_template_id], 200);
    }

    public function update(Request $request){
        dd($request->all());
    }

    //Hàm này để lưu lại review từ form review trong email nhé
    public function saveReview(Request $request){
        dd($request->all());
        return 'save success';
    }

    public function getTemplateInfo(Request $request)
    {
        $data = $request->all();
        $template = DB::table('review_request')
            ->where('id', $data['template_id'])
            ->first();
        return response()->json(['message' => 'success', 'data' =>$template, 'code' => 200], 200);

    }
}
