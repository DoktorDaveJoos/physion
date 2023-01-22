<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bedarfsausweis extends Model
{
    use HasFactory;

    protected $table = 'bedarfsausweise';

    protected $casts = [
        'cooling_service' => 'datetime',
    ];
    protected $guarded = ['id'];

}
