<?php

namespace App\Notifications;

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class FindOrderNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Customer $customer)
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
        $mailMessage = (new MailMessage)
            ->subject('Ihre Order bei Bauzertifikate.de')
            ->greeting('Hallo '.$this->customer->name.',')
            ->line('Anbei die Links zu Ihren Bestellungen: ');

        $this->customer->orders->each(function (Order $order) use ($mailMessage) {
            $mailMessage->line('Bestellnummer: '.$order->slug)
                ->line('Bestellung einsehen: ' . URL::signedRoute('order.show', ['order' => $order->slug]));
        });

        $mailMessage
            ->line('Bei Fragen stehen wir Ihnen gerne zur Verfügung.')
            ->line('Mit freundlichen Grüßen')
            ->line('Ihr Bauzertifikate Team')
            ->salutation('Bauzertifikate.de');

        return $mailMessage;
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
