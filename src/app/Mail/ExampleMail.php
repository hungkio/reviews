<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

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
        if($this->details['type'] == 'test'){
            return $this->view('mails.review-destination')
                ->subject('Stripe')
                ->with($this->details);
        }else if($this->details['type'] == 'demo'){
            return $this->view('mails.rating')
                ->subject('Review')
                ->with($this->details);
        }

    }
}
