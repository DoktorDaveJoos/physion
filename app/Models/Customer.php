<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
