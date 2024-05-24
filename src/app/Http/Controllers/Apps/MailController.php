<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Mail\ExampleMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function sendEmail()
    {
        $details = [
            'title' => 'Mail from Laravel',
            'body' => 'This is a test email sent from Laravel.'
        ];

        Mail::to('tranvhoangnd@gmail.com')->send(new ExampleMail($details));

        return "Email Sent!";
    }
}
