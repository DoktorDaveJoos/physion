<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BlogEntry extends Model
{
    use HasFactory;

    static function findBySlug(string $slug): BlogEntry
    {
        return BlogEntry::where('slug', $slug)->with(['user'])->firstOrFail();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
