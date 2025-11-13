<?php

namespace App\Domains\Permissions\Repositories;

use Spatie\Permission\Models\Permission;

class PermissionEntityRepository
{
    public function all()
    {
        return Permission::all();
    }

    public function find($id)
    {
        return Permission::find($id);
    }

    public function create(array $data)
    {
        return Permission::create($data);
    }

    public function update($id, array $data)
    {
        $model = Permission::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function delete($id)
    {
        return Permission::destroy($id);
    }
}


