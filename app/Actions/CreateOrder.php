<?php

namespace App\Actions;

use App\Enums\Category;
use App\Models\Bdrf;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\Vrbr;
use App\Notifications\OrderCreated;
use App\Services\NanoIdCore;
use App\Shared\Transferable;
use Closure;
use Hidehalo\Nanoid\Client;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use Lorisleiva\Actions\Concerns\AsAction;
use Throwable;

class CreateOrder
{
    use AsAction;

    public function __construct(
        private readonly Client $nanoClient,
    ) {
    }

    /**
     * @throws Throwable
     */
    public function handle(Bdrf|Vrbr $certificate, Customer $customer, mixed $data)
    {
        // Create slug
        $slug = $this->nanoClient->formattedId(
            NanoIdCore::CUSTOM_SYMBOLS,
            NanoIdCore::ID_LENGTH
        );

        // Create Order
        $order = Order::create(
            array_merge($data, [
                'slug' => $slug,
                'customer_id' => $customer->id,
                'certificate_id' => $certificate->id,
                'certificate_type' => $certificate::class,
                'meta' => ['steps' => ['general']],
            ])
        );

        $product = Product::whereCategory(Category::fromModel($certificate::class)->value)->first();

        if (!$product) {
            abort(404, 'Product not found');
        }

        // Attach Product of Certificate
        $order->products()->attach($product);

        // Notify Customer
        $customer->notify((new OrderCreated($order, $customer->name))->locale('de'));

        return $order;
    }

    /**
     * @param  Transferable  $transferable
     * @param  Closure  $next
     * @return mixed
     */
    public function pipeable(Transferable $transferable, Closure $next): mixed
    {
        $order = self::run(
            $transferable->getCertificate(),
            $transferable->getCustomer(),
            $transferable->getData()
        );

        return $next($order);
    }
}
