<?php

namespace App\Actions;

use App\Enums\Category;
use App\Models\Bdrf;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Vrbr;
use App\Notifications\OrderCreated;
use App\Services\NanoIdCore;
use App\Shared\Transferable;
use App\Support\Telegram\Telegram;
use Closure;
use Hidehalo\Nanoid\Client;
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
    public function handle(Bdrf|Vrbr $certificate, ?Customer $customer, ?User $user, mixed $data)
    {
        // Create slug
        $slug = $this->nanoClient->formattedId(
            NanoIdCore::CUSTOM_SYMBOLS,
            NanoIdCore::ID_LENGTH
        );

        $ownerData = [
            'owner_id' => $customer->id ?? $user->id,
            'owner_type' => $customer ? Customer::class : User::class,
        ];

        if ($user) {
            $ownerData['team_id'] = $user->current_team_id;
        }

        // Create Order
        $order = Order::create(
            array_merge(
                $data,
                [
                    'slug' => $slug,
                    'certificate_id' => $certificate->id,
                    'certificate_type' => $certificate::class,
                    'meta' => ['steps' => ['general']],
                ] + $ownerData
            )
        );

        $product = Product::whereCategory(Category::fromModel($certificate::class)->value)->first();

        if (!$product) {
            abort(404, 'Product not found');
        }

        // Attach Product of Certificate
        $order->products()->attach($product);

        // Notify Customer
        $customer?->notify((new OrderCreated($order, $customer->name))->locale('de'));

        // Notify Bauzertifikate Team - @todo make async
        Telegram::broadcast("[Order created] $order->owner->name: $order->certificate_type");

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
            $transferable->getUser(),
            $transferable->getData()
        );

        return $next($order);
    }
}
