<?php

namespace App\Actions;

use Closure;
use Hidehalo\Nanoid\Client;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateCertificate
{
    use AsAction;

    public function handle(mixed $data)
    {

        $handler = $data['category']->getHandler();

        return $handler::create($data);

    }

    public function pipeable(mixed $data, Closure $next): mixed
    {
        $certificate = self::run($data);

        return $next(array_merge($data, [
            'certificate_id' => $certificate->id,
        ]));
    }
}
