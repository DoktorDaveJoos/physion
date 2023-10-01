<?php

namespace App\Models;

use App\Casts\LayoutCast;
use App\Models\Building\Layout;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use PhpParser\Node\Scalar\String_;

/**
 * @property int $id
 * @property int $team_id
 * @property string $street
 * @property string $house_number
 * @property string $postal_code
 * @property string $city
 * @property string $state
 * @property string $country
 * @property string $additional_info
 * @property string $place_id
 * @property string $image
 */
class Building extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'layout' => LayoutCast::class,
    ];

    public function createdBy(): belongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function vrbr(): HasOne
    {
        return $this->hasOne(Vrbr::class);
    }

    public function bdrf(): HasOne
    {
        return $this->hasOne(Bdrf::class);
    }

    public function energyCertificates(): HasMany
    {
        return $this->hasMany(EnergyCertificate::class);
    }

    public function isfp(): HasOne
    {
        return $this->hasOne(Isfp::class);
    }

    public function wall(): HasOne
    {
        return $this->hasOne(Wall::class);
    }

    public function roof(): HasOne
    {
        return $this->hasOne(Roof::class);
    }

    public function cellarObject(): HasOne
    {
        return $this->hasOne(Cellar::class);
    }

    public function heatingSystems(): HasMany
    {
        return $this->hasMany(HeatingSystem::class);
    }

    public function renewableEnergyInstallations(): HasMany
    {
        return $this->hasMany(RenewableEnergyInstallation::class);
    }

    public function consumptions(): HasMany
    {
        return $this->hasMany(Consumption::class);
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(Attachment::class);
    }

    public function storagePath(): string
    {
        return 'buildings/' . $this->id;
    }
}
