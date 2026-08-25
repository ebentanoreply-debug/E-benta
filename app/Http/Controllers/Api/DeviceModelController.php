<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DeviceModel;
use Illuminate\Http\Request;

class DeviceModelController extends Controller
{
    /**
     * Get models for a specific device type
     */
    public function byType($typeId)
    {
        $models = DeviceModel::where('device_type_id', $typeId)
            ->with('brand')
            ->get()
            ->map(function($model) {
                return [
                    'id' => $model->id,
                    'model_name' => $model->model_name,
                    'brand_name' => $model->brand->name,
                    'display_name' => "{$model->model_name} ({$model->brand->name})"
                ];
            });

        return response()->json($models);
    }
}
