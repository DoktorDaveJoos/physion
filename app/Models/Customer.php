<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;

/**
 * @property string id
 * @property string stripe_customer_id
 * @property string first_name
 * @property string last_name
 * @property string name
 * @property string email
 * @property string phone
 * @property string address_line_1
 * @property string address_line_2
 * @property string postal_code
 * @property string city
 * @property string state
 * @property string country
 * @property Collection<Order> orders
 */
class Customer extends Model
{
    use HasFactory;
    use Notifiable;

    protected $guarded = ['id'];

    public function getNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function orders(): MorphMany
    {
        return $this->morphMany(Order::class, 'owner');
    }
}
