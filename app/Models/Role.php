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
 * @property Collection<User> $users
 * @property Collection<Resource> $resources
 */
class Role extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_has_roles');
    }

    public function resources(): BelongsToMany
    {
        return $this->belongsToMany(Resource::class, 'role_has_resources');
    }
}
