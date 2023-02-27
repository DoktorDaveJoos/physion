<?php
namespace App\Services;

use Hidehalo\Nanoid\CoreInterface;

interface NanoIdCore extends CoreInterface
{
    const CUSTOM_SYMBOLS = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    const ID_LENGTH = 6;
}
