<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class LockDownLiftedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct()
    {
        //
    }

    public function build()
    {
        return $this->to('staff@dinotopia.com')
            ->subject('PARK LOCKDOWN!')
            ->view('emails.lockdown_notification');
    }

    public function via($notifiable)
    {
        return ['mail'];
    }
}
