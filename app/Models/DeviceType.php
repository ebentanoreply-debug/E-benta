<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DeviceType extends Model
{
    protected $fillable = [
        'name',
        'description',
        'icon',
    ];

    /**
     * Get the brands for this device type.
     */
    public function models(): HasMany
    {
        return $this->hasMany(DeviceModel::class);
    }

    /**
     * Get the listings for this device type.
     */
    public function listings(): HasMany
    {
        return $this->hasMany(Listing::class, 'device_type_id');
    }
}
