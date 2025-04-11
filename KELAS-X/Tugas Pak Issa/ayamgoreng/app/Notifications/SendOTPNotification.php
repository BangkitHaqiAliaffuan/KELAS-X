<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendOTPNotification extends Notification
{
    use Queueable;
    public $otp;
    /**
     * Create the event listener.
     */
    public function __construct($otp)
    {
        $this->otp = $otp;
    }

    public function via($notifiable){
        return ['mail'];
    }

    public function toMail($notifiable){
        return (new MailMessage)
        ->line('This is your otp code'. $this->otp)
        ->line('Thankyou for using our app')
        ;
    }

    /**
     * Handle the event.
     */
    public function toArray($notifiable): void
    {
        return [

        ];
    }
}
