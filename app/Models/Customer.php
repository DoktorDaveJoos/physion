<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

/**
 * @property string id
 * @property string stripe_customer_id
 * @property string name
 * @property string email
 * @property string phone
 * @property string address_line_1
 * @property string address_line_2
 * @property string postal_code
 * @property string city
 * @property string state
 * @property string country
 */
class Customer extends Model
{
    use HasFactory;
    use Notifiable;

    protected $guarded = ['id'];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
