<?php
namespace App\Services;

use Hidehalo\Nanoid\CoreInterface;

interface NanoIdCore extends CoreInterface
{
    const CUSTOM_SYMBOLS = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    const ID_LENGTH = 6;
}
