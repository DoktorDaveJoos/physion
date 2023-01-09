<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bedarfsausweis extends Model
{
    use HasFactory;
    protected $table = 'bedarfsausweise';
    protected $fillable = [
        'uuid',
        'street_address',
        'zip',
        'city',
        'type',
        'additional_type',
        'housing_units',
        'construction_year',
    ];
}
