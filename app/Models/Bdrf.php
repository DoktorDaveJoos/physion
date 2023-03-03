<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Bdrf extends Model
{
    use HasFactory;

    protected $table = 'bdrfs';

    protected $guarded = ['id'];

    protected $casts = [
        'cooling_service' => 'datetime',
    ];

    public function order(): MorphOne
    {
        return $this->morphOne(Order::class, 'certificate');
    }

    public function roof(): HasOne
    {
        return $this->hasOne(Roof::class);
    }

    public function wall(): HasOne
    {
        return $this->hasOne(Wall::class);
    }
}
