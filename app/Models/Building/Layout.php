<?php

namespace App\Models\Building;

enum Layout
{
    case Rectangle;
    case L;
    case U;
    case T;
    case H;

    public static function fromString(string|null $layout): Layout
    {
        return match ($layout) {
            'l' => self::L,
            'u' => self::U,
            't' => self::T,
            'h' => self::H,
            default => self::Rectangle
        };
    }

    public function toString(): string
    {
        return match ($this) {
            self::Rectangle => 'Rechteck',
            self::L => 'L-Form',
            self::U => 'U-Form',
            self::T => 'T-Form',
            self::H => 'H-Form',
        };
    }

}
