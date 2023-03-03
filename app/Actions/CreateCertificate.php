<?php

namespace App\Actions;

use App\Enums\Category;
use App\Models\Customer;
use App\Services\NanoIdCore;
use App\Shared\Transferable;
use Closure;
use Hidehalo\Nanoid\Client;
use Illuminate\Database\Eloquent\Model;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateCertificate
{
    use AsAction;

    public function __construct(
        private readonly Client $nanoClient,
    ) {
    }

    /**
     * @param  Category  $category
     * @param  array<string, mixed>  $data
     * @return mixed
     */
    public function handle(Category $category, mixed $data): mixed
    {
        return $category->getModel()::create($data);
    }

    public function pipeable(Transferable $transferable, Closure $next): mixed
    {
        $certificate = self::run(
            $transferable->getCategory(),
            $transferable->getData()
        );

        return $next(Transferable::make(
            $transferable->getData(),
            $transferable->getCategory(),
            $transferable->getCustomer(),
            null,
            $certificate
        ));
    }
}
