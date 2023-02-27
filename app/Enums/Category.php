<?php

namespace App\Enums;

use App\Models\Bdrf;
use App\Models\Vbrc;

enum Category: String
{

    case BDRF = 'bdrf';
    case VBRC = 'vbrc';

    public function getHandler(): string
    {
        return match ($this) {
            self::BDRF => Bdrf::class,
            self::VBRC => Vbrc::class,
        };
    }

}
