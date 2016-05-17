<?php

namespace App\Listeners;

use App\Events\SendMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use App\Admin;

class SendMailFired
{

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SendMail  $event
     * @return void
     */
    public function handle(SendMail $event)
    {
        
        $body = [
            'body' => 'Login successfully.',
        ];
        Mail::send('emails.welcome', $body, function($message) {
            $message->to('test.mail.laravel@gmail.com');
            $message->from('test.mail.laravel@gmail.com', 'event');
            $message->subject('Event');
        });
    }
}
