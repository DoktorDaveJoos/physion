<?php

declare(strict_types=1);

namespace App\Actions;

use Throwable;

interface Action
{

    /**
     * @param  mixed  ...$arguments
     * @return mixed
     * @throws Throwable
     */
    public static function handle(...$arguments): mixed;


}
