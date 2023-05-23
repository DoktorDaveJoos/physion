<?php

namespace App\Actions;

use App\Models\Bdrf;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Vrbr;
use App\Services\NanoIdCore;
use App\Shared\Transferable;
use Closure;
use Hidehalo\Nanoid\Client;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateOrder
{
    use AsAction;

    public function __construct(
        private readonly Client $nanoClient,
    ) {
    }

    public function handle(Bdrf|Vrbr $certificate, Customer $customer, mixed $data)
    {
        $slug = $this->nanoClient->formattedId(
            NanoIdCore::CUSTOM_SYMBOLS,
            NanoIdCore::ID_LENGTH
        );

        return Order::create(
            array_merge($data, [
                'slug' => $slug,
                'customer_id' => $customer->id,
                'certificate_id' => $certificate->id,
                'certificate_type' => $certificate::class,
                'meta' => ['steps' => ['general']],
            ])
        );
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
