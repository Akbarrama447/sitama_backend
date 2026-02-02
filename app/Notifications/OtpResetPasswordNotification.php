<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OtpResetPasswordNotification extends Notification
{
    use Queueable;

    protected $otp;

    /**
     * Create a new notification instance.
     *
     * @param  string  $otp
     * @return void
     */
    public function __construct($otp)
    {
        $this->otp = $otp;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('OTP Reset Password SITAMA')
            ->line('Anda menerima email ini karena ada permintaan reset password untuk akun Anda.')
            ->line('OTP (One-Time Password) Anda adalah:')
            ->line('**'.$this->otp.'**')  // OTP ditampilkan dengan bold
            ->line('OTP ini berlaku selama 10 menit.')
            ->line('Jika Anda tidak merasa melakukan permintaan reset password, abaikan email ini.')
            ->salutation('Hormat Kami, Tim SITAMA');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}