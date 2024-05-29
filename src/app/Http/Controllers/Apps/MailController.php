<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Mail\ExampleMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class MailController extends Controller
{
    public function sendEmail(Request $request)
    {
        return view('mails.rating');
        if($request->all()['type'] == 'demo'){
            $details = [
                'type' => 'test',
                'data' => [
                    'order-id' => '$#187189',
                    'name' => 'Test send mail',
                    'email' => 'tranvhoangnd@gmail.com',
                    'phone' => '0123456789',
                    'address' => 'Hoang Sa Truong Sa belongs to Viet Nam',
                    'content' => 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.',
                ],
            ];
        }

        if($request->all()['type'] == 'review'){
            $details = [
                'type' => 'review',
                'data' => [
                    'order-id' => '8973624892763',
                    'name' => 'No Name No Same',
                    'email' => 'tranvhoangnd@gmail.com',
                    'phone' => '0123456789',
                    'address' => 'Hoang Sa Truong Sa belongs to Viet Nam',
                    'content' => 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.',
                ],
            ];
        }

        $email = isset($details['data']['email']) ? $details['data']['email'] : null;

        if ($email) {
            Mail::to($email)->send(new ExampleMail($details));
        }
    }
}
