<?php

namespace App\Domains\Settings\Repositories;

use App\Domains\Settings\Models\SettingEntity;
use Illuminate\Support\Facades\Storage;

class SettingEntityRepository
{
    public function all()
    {
        return SettingEntity::all();
    }

    public function find($id)
    {
        return SettingEntity::find($id);
    }

    public function save(array $data)
    {
        $model = SettingEntity::first();

        if ($model) {
            // لو فيه لوجو جديد، احذف القديم
            if (isset($data['logo']) && $model->logo && Storage::disk('public')->exists($model->logo)) {
                Storage::disk('public')->delete($model->logo);
            }

            if (isset($data['brand_image']) && $model->brand_image && Storage::disk('public')->exists($model->brand_image)) {
                Storage::disk('public')->delete($model->brand_image);
            }

            $model->update($data);
        } else {
            $model = SettingEntity::create($data);
        }

        return $model;
    }
}
