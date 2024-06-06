<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ExampleMail extends Mailable
{
    use Queueable, SerializesModels;

    public $details;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->details['type'] == 'demo' || $this->details['type'] == 'feedback'){
            return $this->view('mails.review-destination')
                ->subject('Stripe')
                ->with($this->details);
        }else if($this->details['type'] == 'review'){
            $email_subject = $this->details['reviewRequests']->email_subject ?? 'Review'; 
            Log::info($email_subject);
            Log::info(json_encode($this->details));
            return $this->view('mails.rating')
                ->subject($email_subject)
                ->with($this->details);

        }

    }
}
