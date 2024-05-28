<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        // $user = Auth::user();
        // $account_id = $user->account_id;
        // $requests = DB::table('review_request')->where('account_id',$account_id)->get();
        // foreach ($requests as $request) {
        //     $interval_date = $request->interval_date;
        //     $interval_type = $request->interval_type;
        //     $email_subject = $request->email_subject;
        //     $email_body = $request->email_body;
        //     $rating_style = $request->rating_style;
        //     // $interval_date = Carbon::parse($request->interval_date);
        //     // $next_notification_date = $interval_date->addDays($interval_days);
    
        //     // Tính toán thời gian tiếp theo để gửi thông báo
        //     if ($next_notification_date->isToday()) {
        //         $schedule->command('send:email-review', [
        //         ])->dailyAt();
        //     }
        // }
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
