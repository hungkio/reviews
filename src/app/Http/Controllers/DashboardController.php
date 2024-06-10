<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function index()
    {
        addVendors(['amcharts', 'amcharts-maps', 'amcharts-stock']);

        $currentMonth = Carbon::now()->startOfMonth();
        $previousMonth = Carbon::now()->subMonth()->startOfMonth();
        $twoMonthsAgo = Carbon::now()->subMonths(2)->startOfMonth();

        $currentMonthName = $currentMonth->format('F Y');
        $currentMonthStart = $currentMonth->toDateString();
        $currentMonthEnd = $currentMonth->endOfMonth()->toDateString();

        $previousMonthName = $previousMonth->format('F Y');
        $previousMonthStart = $previousMonth->toDateString();
        $previousMonthEnd = $previousMonth->endOfMonth()->toDateString();

        $twoMonthsAgoName = $twoMonthsAgo->format('F Y');
        $twoMonthsAgoStart = $twoMonthsAgo->toDateString();
        $twoMonthsAgoEnd = $twoMonthsAgo->endOfMonth()->toDateString();

        $monthsData = [
            [
                'name' => $currentMonthName,
                'start' => $currentMonthStart,
                'end' => $currentMonthEnd,
            ],
            [
                'name' => $previousMonthName,
                'start' => $previousMonthStart,
                'end' => $previousMonthEnd,
            ],
            [
                'name' => $twoMonthsAgoName,
                'start' => $twoMonthsAgoStart,
                'end' => $twoMonthsAgoEnd,
            ],
        ];

        $get_account_id = Auth::user()->account_id;

        $result = collect($monthsData)->map(function ($month) use ($get_account_id) {
            $get_request_sent = DB::table('payments')
                ->where('account_id', $get_account_id)
                ->whereBetween('created_at', [$month['start'], $month['end']])
                ->whereIn('status_email', ['Sent', 'Reviewed'])
                ->get();

            $get_review_received = DB::table('reviews')
                ->where('account_id', $get_account_id)
                ->whereBetween('created_at', [$month['start'], $month['end']])
                ->get();

            $month['count_request_sent'] = count($get_request_sent);
            $month['count_review_received'] = count($get_review_received);
            return $month;
        });


        return view('pages/dashboards.index', compact('result'));
    }

    public function update(UserRequest $request)
    {
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['password'] = Hash::make($request->password);

        auth()->user()->update($data);
        return back()->with(['success' => 'Update profile successfully']);

    }
}
