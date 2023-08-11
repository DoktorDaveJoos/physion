<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property Collection<Team> $teams
 */
class Resource extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class, 'team_has_resources');
    }
}
