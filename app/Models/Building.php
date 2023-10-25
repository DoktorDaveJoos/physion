<?php

namespace App\Models;

use App\Casts\LayoutCast;
use App\Models\Scopes\TeamScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property int $team_id
 * @property int $created_by
 * @property bool $new_building
 * @property string $street
 * @property string $house_number
 * @property string $postal_code
 * @property string $city
 * @property string $state
 * @property string $country
 * @property string $type
 * @property string $additional_type
 * @property int $construction_year
 * @property int $floor_area
 * @property int $land_area
 * @property int $floors
 * @property int $floor
 * @property int $rooms
 * @property string $additional_info
 * @property string $place_id
 * @property Roof $roof
 * @property Wall $wall
 * @property Cellar $cellar
 * @property Collection<Heating> $heatings
 * @property Collection<Renewable> $renewables
 */
class Building extends Model
{

    const FLAT = 'Wohnung';


    protected static function booted(): void
    {
        static::addGlobalScope(new TeamScope);
    }

    protected $guarded = ['id'];

    protected $casts = [
        'layout' => LayoutCast::class,
    ];

    public function createdBy(): belongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function energyCertificates(): HasMany
    {
        return $this->hasMany(EnergyCertificate::class);
    }

    public function isfp(): HasOne
    {
        return $this->hasOne(Isfp::class);
    }

    public function bza(): HasOne
    {
        return $this->hasOne(Bza::class);
    }

    public function wall(): HasOne
    {
        return $this->hasOne(Wall::class);
    }

    public function roof(): HasOne
    {
        return $this->hasOne(Roof::class);
    }

    public function cellar(): HasOne
    {
        return $this->hasOne(Cellar::class);
    }

    public function heatings(): HasMany
    {
        return $this->hasMany(Heating::class);
    }

    public function renewables(): HasMany
    {
        return $this->hasMany(Renewable::class);
    }

    public function consumptions(): HasMany
    {
        return $this->hasMany(Consumption::class);
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(Attachment::class);
    }

    public function predictions(): HasMany
    {
        return $this->hasMany(Prediction::class);
    }

    public function storagePath(): string
    {
        return 'buildings/'.$this->id;
    }

    public function isHouse(): bool
    {
        return $this->type !== self::FLAT;
    }
}
