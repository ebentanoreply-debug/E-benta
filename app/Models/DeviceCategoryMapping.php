<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceCategoryMapping extends Model
{
    protected $table = 'device_category_mappings';
    protected $fillable = ['device_type_id', 'device_brand_id', 'device_model_id', 'category'];

    public function deviceType()
    {
        return $this->belongsTo(DeviceType::class);
    }

    public function deviceBrand()
    {
        return $this->belongsTo(DeviceBrand::class);
    }

    public function deviceModel()
    {
        return $this->belongsTo(DeviceModel::class);
    }
}
