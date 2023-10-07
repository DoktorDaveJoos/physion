<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bza extends Model
{
    use HasFactory;

    protected $fillable = [
        'building_id',
        'customer_id',
        'product_id',
        'status',
        'target',
        'bza_number',
        'bza_path',
        'power_of_attorney_path',
    ];
}
