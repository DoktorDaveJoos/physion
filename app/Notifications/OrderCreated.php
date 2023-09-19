<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class OrderCreated extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Order $order, public string $name)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $url = URL::signedRoute('order.show', ['order' => $this->order->slug]);
        return (new MailMessage)
            ->subject('Willkommen bei Bauzertifikate.de')
            ->greeting('Hallo ' . $this->name)
            ->line('Schön, dass Sie sich für Bauzertifikate.de entschieden haben.')
            ->line('Ihre Bestellnummer lautet: ' . $this->order->slug)
            ->line('Über die Bestellnummer finden Sie Ihre Bestellung jederzeit wieder.')
            ->line('Sie können Ihre Bestellung unter folgendem Link einsehen:')
            ->action('Bestellung einsehen', $url)
            ->line('Bei Fragen stehen wir Ihnen gerne zur Verfügung.')
            ->line('Mit freundlichen Grüßen')
            ->line('Ihr Bauzertifikate Team')
            ->salutation('Bauzertifikate.de');
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
