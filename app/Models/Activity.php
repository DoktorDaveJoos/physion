<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Activity extends Model
{
//    use HasFactory;

    protected $guarded = ['id'];

    public const CREATED = 'erstellt';
    public const UPDATED = 'bearbeitet';
    public const ADDED = 'hinzugefügt';
    public const DELETED = 'gelöscht';
    public const COMMENTED = 'kommentiert';


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}
