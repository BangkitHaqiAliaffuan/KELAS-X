<?php

namespace App\Listeners;

use App\Notifications\SendOTPNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Queue\InteractsWithQueue;

class SendOTPEventListener
{


    public function handle($event){
        $event->user->notify(new SendOTPNotification($event->user->activeOtp->otp_code));
    }
}
