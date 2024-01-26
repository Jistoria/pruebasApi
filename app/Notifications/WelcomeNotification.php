<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeNotification extends Notification
{
    use Queueable;
    
    private $userName;

    /**
     * Create a new notification instance.
     */
    
    /**
     * Create a new notification instance.
     */
    public function __construct($userName)
    {
        //
        $this->userName = $userName;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the broadcastable representation of the notification.
     *
     * @return BroadcastMessage
     */
    public function toDatabase(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'message' => "¡Bienvenido {$this->userName} ! Gracias por unirte a nuestra aplicación.",
        ]);
    }
    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function getType(): string
    {
        // Personaliza el valor del tipo como desees
        return 'welcome_notification';
    }

    /**
     * Get the notifiable type of the notification.
     *
     * @return string
     */
    public function getNotifiableType(): string
    {
        // Personaliza el valor del tipo de notifiable como desees
        return 'custom_user';
    }
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
