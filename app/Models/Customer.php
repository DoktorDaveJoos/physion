<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string id
 * @property string name
 * @property string email
 * @property string phone_number
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

    protected $guarded = ['id'];

    public function unknownToStripe(): bool
    {
        return $this->checkout !== 'stripe' && $this->stripe_id === null;
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
