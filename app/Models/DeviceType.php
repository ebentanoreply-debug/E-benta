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
}
