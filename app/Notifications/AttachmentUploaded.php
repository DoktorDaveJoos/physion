<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class AttachmentUploaded extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Order $order, public string $name, public string $path, public string $filename)
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
            ->subject('Ihre Bestellung bei Bauzertifikate.de')
            ->greeting('Hallo ' . $this->name)
            ->line('Es wurde ein neues Dokument hochgeladen.')
            ->line('Ihre Bestellnummer lautet: ' . $this->order->slug)
            ->line('Über die Bestellnummer finden Sie Ihre Bestellung jederzeit wieder.')
            ->line('Sie können Ihre Bestellung unter folgendem Link einsehen:')
            ->action('Bestellung einsehen', $url)
            ->line('Das Dokument ist nur für Sie einsehbar und wird nicht öffentlich zugänglich gemacht.')
            ->line('Beachten Sie, dass das Dokument der Email angehängt ist.')
            ->line('Bei Fragen stehen wir Ihnen gerne zur Verfügung.')
            ->line('Mit freundlichen Grüßen')
            ->line('Ihr Bauzertifikate Team')
            ->salutation('Bauzertifikate.de')
            ->attachData(Storage::get($this->path), $this->filename, [
                'mime' => 'application/pdf',
            ]);
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
