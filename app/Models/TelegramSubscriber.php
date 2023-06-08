<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $user_telegram_id
 * @property string $chat_id
 * @property string $first_name
 * @property string $last_name
 * @property string $username
 */
class TelegramSubscriber extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
}
