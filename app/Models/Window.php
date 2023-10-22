<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Window extends Model
{

    const SKYLIGHT = 'dachfenster';
    const WINDOW = 'fenster';

    protected $guarded = ['id'];

    public function windowable(): MorphTo
    {
        return $this->morphTo();
    }

}
