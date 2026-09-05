<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DeviceBrand extends Model
{
    protected $fillable = [
        'name',
        'description',
        'logo_url',
    ];

    /**
     * Get the models for this brand.
     */
    public function models(): HasMany
    {
        return $this->hasMany(DeviceModel::class);
    }

    /**
     * Get the listings for this brand.
     */
    public function listings(): HasMany
    {
        return $this->hasMany(Listing::class, 'device_brand_id');
    }
}
