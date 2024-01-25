<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Notify_Community_Member extends Notification
{
    use Queueable;
    protected $User_Notify;

    /**
     * Create a new notification instance.
     */
    public function __construct($User_Notify)
    {
        $this->User_Notify = $User_Notify;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        // $url = url('/user/'.$this->User_Notify['id']);
        return (new MailMessage)
        ->subject('User Status')
        ->from('tutuapp.center.dmn@gmail.com', 'Yash')
        ->greeting("Hy, ".$this->User_Notify['email'])
        ->line('We appoint you to be the part of the '."Community:".$this->User_Notify['Community_Name']
        . " in the channel: " .$this->User_Notify['channel_Name'] ." At Role:- ".$this->User_Notify['Role'])
        ->line($this->User_Notify['showText'])
        ->line('click the below link for approval!')
        // ->action('Approve', url('/user', $this->User_Notify['id'],'/community',$this->User_Notify['Community_ID'],'/channel',$this->User_Notify['channel_ID']))
                // ->action('Approve', url('/user'))
                // ->action('View Invoice', $url)

        ->line('Best regards!')
        ->line("From: ".$this->User_Notify['From']);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
