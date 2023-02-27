<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Bdrf extends Model
{
    use HasFactory;

    protected $table = 'bedarfsausweise';

    protected $casts = [
        'cooling_service' => 'datetime',
    ];

    protected $guarded = ['id'];

    public function roof(): HasOne
    {
        return $this->hasOne(Roof::class);
    }

    public function wall(): HasOne
    {
        return $this->hasOne(Wall::class);
    }
}
