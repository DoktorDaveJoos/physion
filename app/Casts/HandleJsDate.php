<?php

namespace App\Casts;

use Carbon\Carbon;
use DateTime;
use DateTimeZone;
use Exception;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class HandleJsDate implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return DateTime|null
     */
    public function get($model, string $key, $value, array $attributes): DateTime | null
    {
        return $value ? Carbon::parse($value)->timezone('CET') : null;
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return Carbon|null
     */
    public function set($model, string $key, $value, array $attributes): ?Carbon
    {
        return $value ? Carbon::parse($value): null;
    }
}
