<?php

namespace App\Models;

use App\Casts\LayoutCast;
use App\Models\Building\Layout;
use App\Models\Scopes\TeamScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

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
class Building extends Model implements HasMedia
{

    use InteractsWithMedia;

    const FLAT = 'Wohnung';

    const MAPS_INITIAL = 'initial';
    const MAPS_AGREED = 'agreed';



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

    public function team(): belongsTo
    {
        return $this->belongsTo(Team::class);
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
        return 'buildings/' . $this->id;
    }

    public function isHouse(): bool
    {
        return $this->type !== self::FLAT;
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this
            ->addMediaConversion('preview')
            ->fit(Manipulations::FIT_CROP, 300, 300)
            ->nonQueued();
    }

    public function generalDone(): bool
    {
        // Check if general data is set
        $base = $this->street &&
            $this->postal_code &&
            $this->city &&
            $this->type &&
            $this->construction_year &&
            $this->floor_area &&
            $this->floors &&
            $this->ventilation;

        if ($this->type === self::FLAT) {
            return $base && $this->floor && $this->rooms;
        }

        return $base &&
            $this->land_area &&
            $this->housing_units;
    }

    public function positionDone(): bool
    {
        if ($this->maps === self::MAPS_INITIAL) {
            return false;
        }

        $base = $this->layout
            && $this->side_a
            && $this->side_b;

        if ($this->layout !== Layout::Rectangle) {
            $base = $base && $this->side_c && $this->side_d;
        }

        if ($this->maps === self::MAPS_AGREED) {
            return $base;
        }

        return $base && $this->orientation;
    }

    public function thermalDone(): bool
    {
        return $this->wall && $this->roof && $this->cellar;
    }

    public function heatingDone(): bool
    {
        // Return false if no heating is set
        if ($this->heatings->count() === 0) {
            return false;
        }

        return $this->heatings->every(fn(Heating $heating) => $heating->water_included === true);
    }

    public function renewableDone(): bool
    {
        return $this->renewables->count() > 0;
    }

    public function consumptionDone(): bool
    {
        return $this->consumptions->count() > 0 && $this->consumptions()->sum('period') >= 36;
    }
}
