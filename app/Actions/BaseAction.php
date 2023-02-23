<?php

declare(strict_types=1);

namespace App\Actions;

use Throwable;

abstract class BaseAction implements Action
{

    /**
     * @param  mixed  ...$arguments
     * @return mixed
     * @throws Throwable
     */
    public static function handle(...$arguments): mixed
    {
        return static::make()->run(...$arguments);
    }

    /**
     * @param  mixed  ...$arguments
     * @return static
     */
    public static function make(...$arguments): static
    {
        return new static();
    }

    /**
     * @param  mixed  ...$arguments
     * @return mixed
     */
    abstract protected function run(...$arguments): mixed;

}
